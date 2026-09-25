<?php

declare(strict_types=1);

use App\Http\Controllers\ImageController;
use App\Models\Media;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

/**
 * Generate real image bytes in the given format via GD.
 */
function imageBytes(string $format = 'png', int $width = 10, int $height = 10): string
{
    $gd = imagecreatetruecolor($width, $height);
    imagefilledrectangle($gd, 0, 0, $width - 1, $height - 1, imagecolorallocate($gd, 120, 60, 200));

    ob_start();
    match ($format) {
        'jpeg' => imagejpeg($gd),
        'gif' => imagegif($gd),
        'webp' => imagewebp($gd),
        default => imagepng($gd),
    };
    $bytes = ob_get_clean();
    imagedestroy($gd);

    return $bytes;
}

/**
 * Insert a media row and place its bytes on the (faked) default disk at file_name.
 */
function makeMedia(string $fileName, string $mimeType, string $content): Media
{
    Storage::put($fileName, $content);

    $id = DB::table('media')->insertGetId([
        'model_type' => 'App\Models\Project',
        'model_id' => 1,
        'collection_name' => 'images',
        'name' => pathinfo($fileName, PATHINFO_FILENAME),
        'file_name' => $fileName,
        'mime_type' => $mimeType,
        'disk' => 'public',
        'size' => mb_strlen($content, '8bit'),
        'manipulations' => '[]',
        'custom_properties' => '[]',
        'generated_conversions' => '[]',
        'responsive_images' => '[]',
    ]);

    return Media::findOrFail($id);
}

/**
 * The id-qualified route path for a media row.
 */
function mediaPath(Media $media): string
{
    return $media->getKey() . '/' . $media->file_name;
}

beforeEach(function (): void {
    Storage::fake();
});

it('returns 404 when the media record does not exist', function (): void {
    $this->get(route('image.show', ['path' => '999/missing.png']))
        ->assertNotFound();
});

it('returns 404 when the media row exists but the file is missing', function (): void {
    $id = DB::table('media')->insertGetId([
        'model_type' => 'App\Models\Project',
        'model_id' => 1,
        'collection_name' => 'images',
        'name' => 'ghost',
        'file_name' => 'ghost.png',
        'mime_type' => 'image/png',
        'disk' => 'public',
        'size' => 0,
        'manipulations' => '[]',
        'custom_properties' => '[]',
        'generated_conversions' => '[]',
        'responsive_images' => '[]',
    ]);

    // No original_url reachable and no file on disk => 404.
    $this->get(route('image.show', ['path' => $id . '/ghost.png']))
        ->assertNotFound();
});

it('serves a versioned url as immutable with security headers', function (): void {
    $media = makeMedia('photo.png', 'image/png', imageBytes('png'));

    $response = $this->get($media->imageRouteUrl());

    $response->assertOk()
        ->assertHeader('X-Content-Type-Options', 'nosniff')
        ->assertHeader('Vary', 'Accept');

    expect($response->headers->get('Cache-Control'))->toContain('public')
        ->toContain('immutable')
        ->toContain('max-age=31536000');
});

it('does not advertise immutable caching for an unversioned or stale url', function (?string $version): void {
    $media = makeMedia('photo.png', 'image/png', imageBytes('png'));

    $response = $this->get(route('image.show', ['path' => mediaPath($media), 'v' => $version]));

    $response->assertOk()
        ->assertHeader('Vary', 'Accept');

    expect($response->headers->get('Cache-Control'))->toContain('public')
        ->toContain('max-age=3600')
        ->not->toContain('immutable');
})->with([
    'unversioned' => null,
    'stale version' => '12345',
]);

it('varies on Accept even when the client does not accept webp', function (): void {
    $media = makeMedia('photo.png', 'image/png', imageBytes('png'));

    $this->get(route('image.show', ['path' => mediaPath($media)]), ['Accept' => 'text/html'])
        ->assertOk()
        ->assertHeader('Vary', 'Accept');
});

it('requires the media id so a shared file name cannot resolve to the wrong media', function (): void {
    $first = makeMedia('photo.png', 'image/png', imageBytes('png'));
    $second = makeMedia('photo.png', 'image/png', imageBytes('png'));

    $this->get(route('image.show', ['path' => 'photo.png']))->assertNotFound();
    $this->get(route('image.show', ['path' => $second->getKey() . '/other.png']))->assertNotFound();
    $this->get(route('image.show', ['path' => mediaPath($first)]))->assertOk();
});

it('re-encodes instead of reusing stored output after the media version changes', function (): void {
    $media = makeMedia('photo.png', 'image/png', imageBytes('png'));

    $this->get(route('image.show', ['path' => mediaPath($media)]), ['Accept' => 'image/webp'])
        ->assertOk();

    // Bump the version without firing the observer purge.
    DB::table('media')->where('id', $media->getKey())->update(['updated_at' => now()]);

    $this->get(route('image.show', ['path' => mediaPath($media)]), ['Accept' => 'image/webp'])
        ->assertOk();

    expect(Storage::files(ImageController::CACHE_DIRECTORY))->toHaveCount(2);
});

it('sets an accurate byte Content-Length for binary output', function (): void {
    $media = makeMedia('photo.png', 'image/png', imageBytes('png'));

    $response = $this->get(route('image.show', ['path' => mediaPath($media)]));
    $body = $response->getContent();

    // strlen (byte count), not character count.
    expect((int) $response->headers->get('Content-Length'))
        ->toBe(mb_strlen($body, '8bit'))
        ->toBeGreaterThan(0);
});

it('negotiates webp when the Accept header advertises it', function (): void {
    $media = makeMedia('photo.png', 'image/png', imageBytes('png'));

    $this->get(route('image.show', ['path' => mediaPath($media)]), ['Accept' => 'image/webp,*/*'])
        ->assertOk()
        ->assertHeader('Content-Type', 'image/webp');
});

it('keeps the original format when the client does not accept webp', function (): void {
    $media = makeMedia('photo.png', 'image/png', imageBytes('png'));

    $this->get(route('image.show', ['path' => mediaPath($media)]), ['Accept' => 'text/html'])
        ->assertOk()
        ->assertHeader('Content-Type', 'image/png');
});

it('normalizes a jpg mime type to the jpeg encoder', function (): void {
    // image/jpeg -> ext "jpeg"; a "jpg" ext must map to the jpeg encoder too.
    $media = makeMedia('photo.jpg', 'image/jpg', imageBytes('jpeg'));

    $this->get(route('image.show', ['path' => mediaPath($media)]), ['Accept' => 'text/html'])
        ->assertOk()
        ->assertHeader('Content-Type', 'image/jpeg');
});

it('serves an unknown mime type as webp', function (): void {
    $media = makeMedia('photo.bin', 'image/tiff', imageBytes('png'));

    $this->get(route('image.show', ['path' => mediaPath($media)]), ['Accept' => 'text/html'])
        ->assertOk()
        ->assertHeader('Content-Type', 'image/webp');
});

it('stores the encoded output on disk and reuses it after the source is deleted', function (): void {
    $media = makeMedia('photo.png', 'image/png', imageBytes('png'));

    $this->get(route('image.show', ['path' => mediaPath($media)]), ['Accept' => 'image/webp'])
        ->assertOk();

    expect(Storage::files(ImageController::CACHE_DIRECTORY))->toHaveCount(1);

    // Remove the source; the stored encode must still serve.
    Storage::delete('photo.png');

    $this->get(route('image.show', ['path' => mediaPath($media)]), ['Accept' => 'image/webp'])
        ->assertOk()
        ->assertHeader('Content-Type', 'image/webp');
});

it('purges the encoded output when media changes', function (): void {
    $media = makeMedia('photo.png', 'image/png', imageBytes('png'));

    $this->get(route('image.show', ['path' => mediaPath($media)]), ['Accept' => 'image/webp'])
        ->assertOk();

    expect(Storage::files(ImageController::CACHE_DIRECTORY))->toHaveCount(1);

    $media->delete();

    expect(Storage::files(ImageController::CACHE_DIRECTORY))->toBeEmpty();
});

it('does not rate limit outside production', function (): void {
    $media = makeMedia('photo.png', 'image/png', imageBytes('png'));

    // 20 hits > maxAttempts (10); testing env skips the limiter entirely.
    foreach (range(1, 20) as $ignored) {
        $this->get(route('image.show', ['path' => mediaPath($media)]))->assertOk();
    }
    unset($ignored);
});

it('serves the thumbnail scaled to the card width and cropped to the top of a tall screenshot', function (): void {
    $media = makeMedia('screenshot.png', 'image/png', imageBytes('png', 1400, 5000));

    $response = $this->get($media->thumbnail_url, ['Accept' => 'image/webp'])
        ->assertOk()
        ->assertHeader('Content-Type', 'image/webp');

    expect(getimagesizefromstring($response->getContent()))->toMatchArray([0 => 700, 1 => 1260]);
});

it('ignores an unknown size and serves the original dimensions', function (): void {
    $media = makeMedia('screenshot.png', 'image/png', imageBytes('png', 1400, 900));

    $response = $this->get(route('image.show', ['path' => mediaPath($media), 'size' => 'huge']))
        ->assertOk();

    expect(getimagesizefromstring($response->getContent()))->toMatchArray([0 => 1400, 1 => 900]);
});
