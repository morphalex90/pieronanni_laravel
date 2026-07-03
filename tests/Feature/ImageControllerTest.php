<?php

declare(strict_types=1);

use App\Models\Media;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

/**
 * Generate real image bytes in the given format via GD.
 */
function imageBytes(string $format = 'png'): string
{
    $gd = imagecreatetruecolor(10, 10);
    imagefilledrectangle($gd, 0, 0, 9, 9, imagecolorallocate($gd, 120, 60, 200));

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

beforeEach(function (): void {
    Storage::fake();
});

it('returns 404 when the media record does not exist', function (): void {
    $this->get(route('image.show', ['path' => 'missing.png']))
        ->assertNotFound();
});

it('returns 404 when the media row exists but the file is missing', function (): void {
    DB::table('media')->insert([
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
    $this->get(route('image.show', ['path' => 'ghost.png']))
        ->assertNotFound();
});

it('serves an image from the storage disk with caching + security headers', function (): void {
    makeMedia('photo.png', 'image/png', imageBytes('png'));

    $response = $this->get(route('image.show', ['path' => 'photo.png']));

    $response->assertOk()
        ->assertHeader('X-Content-Type-Options', 'nosniff');

    $cacheControl = $response->headers->get('Cache-Control');
    expect($cacheControl)->toContain('public')
        ->toContain('immutable')
        ->toContain('max-age=31536000');

    $body = $response->getContent();
    expect($response->headers->get('Content-Length'))->toBe((string) mb_strlen($body, '8bit'));
});

it('sets an accurate byte Content-Length for binary output', function (): void {
    makeMedia('photo.png', 'image/png', imageBytes('png'));

    $response = $this->get(route('image.show', ['path' => 'photo.png']));
    $body = $response->getContent();

    // strlen (byte count), not character count.
    expect((int) $response->headers->get('Content-Length'))
        ->toBe(mb_strlen($body, '8bit'))
        ->toBeGreaterThan(0);
});

it('negotiates webp when the Accept header advertises it', function (): void {
    makeMedia('photo.png', 'image/png', imageBytes('png'));

    $this->get(route('image.show', ['path' => 'photo.png']), ['Accept' => 'image/webp,*/*'])
        ->assertOk()
        ->assertHeader('Content-Type', 'image/webp');
});

it('keeps the original format when the client does not accept webp', function (): void {
    makeMedia('photo.png', 'image/png', imageBytes('png'));

    $this->get(route('image.show', ['path' => 'photo.png']), ['Accept' => 'text/html'])
        ->assertOk()
        ->assertHeader('Content-Type', 'image/png');
});

it('normalizes a jpg mime type to the jpeg encoder', function (): void {
    // image/jpeg -> ext "jpeg"; a "jpg" ext must map to the jpeg encoder too.
    makeMedia('photo.jpg', 'image/jpg', imageBytes('jpeg'));

    $this->get(route('image.show', ['path' => 'photo.jpg']), ['Accept' => 'text/html'])
        ->assertOk()
        ->assertHeader('Content-Type', 'image/jpeg');
});

it('serves an unknown mime type as webp', function (): void {
    makeMedia('photo.bin', 'image/tiff', imageBytes('png'));

    $this->get(route('image.show', ['path' => 'photo.bin']), ['Accept' => 'text/html'])
        ->assertOk()
        ->assertHeader('Content-Type', 'image/webp');
});

it('caches the encoded output and reuses it after the source is deleted', function (): void {
    makeMedia('photo.png', 'image/png', imageBytes('png'));

    $this->get(route('image.show', ['path' => 'photo.png']), ['Accept' => 'image/webp'])
        ->assertOk();

    expect(Cache::has('img:encoded:photo.png:webp'))->toBeTrue();

    // Remove the source; the cached encode must still serve.
    Storage::delete('photo.png');

    $this->get(route('image.show', ['path' => 'photo.png']), ['Accept' => 'image/webp'])
        ->assertOk()
        ->assertHeader('Content-Type', 'image/webp');
});

it('does not rate limit outside production', function (): void {
    makeMedia('photo.png', 'image/png', imageBytes('png'));

    // 20 hits > maxAttempts (10); testing env skips the limiter entirely.
    foreach (range(1, 20) as $ignored) {
        $this->get(route('image.show', ['path' => 'photo.png']))->assertOk();
    }
    unset($ignored);
});
