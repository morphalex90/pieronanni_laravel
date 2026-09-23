<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Media;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Encoders\GifEncoder;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\Laravel\Facades\Image;

final class ImageController extends Controller
{
    /**
     * Disk directory holding re-encoded image bytes. These are large binary
     * blobs with a one-year lifetime, so they live on a filesystem disk rather
     * than in the shared cache store, where they would crowd out ordinary keys.
     */
    public const CACHE_DIRECTORY = 'image-cache';

    private const CACHE_DURATION = 31536000; // 1 year

    /**
     * Browser cache lifetime for URLs without a matching version, whose bytes
     * can change in place when the media is replaced.
     */
    private const UNVERSIONED_CACHE_DURATION = 3600; // 1 hour

    private const QUALITY = 75;

    /**
     * Remove every re-encoded image blob. Called when media changes, since the
     * stored bytes of stale versions would otherwise never be read again.
     */
    public static function purgeEncodedCache(): void
    {
        Storage::deleteDirectory(self::CACHE_DIRECTORY);
    }

    public function show(Request $request, string $path): Response
    {
        if (App::isProduction()) {
            $this->ratelimit($request, $path);
        }

        $media = $this->findMedia($path);

        if ($media === null) {
            Log::warning("Media not found: {$path}");
            abort(404);
        }

        $version = $media->imageVersion();
        $isVersioned = $request->query('v') === $version;

        $format = $this->determineFormat($request, $media);
        [$mime, $encoder] = $this->encoderFor($format);

        // Encoded output is immutable per (media, version, format) — store it
        // so we decode+re-encode once instead of on every request.
        $cachePath = self::CACHE_DIRECTORY . '/' . hash('xxh128', $media->getKey() . ':' . $version . ':' . $format);

        $output = Storage::exists($cachePath) ? Storage::get($cachePath) : null;

        if ($output === null || $output === '') {
            $imageContent = $this->loadSource($media, $path);

            try {
                $output = (string) Image::decode($imageContent)->encode($encoder);
            } catch (Exception $e) {
                Log::error("Failed to encode image: {$path}", ['exception' => $e->getMessage()]);

                // Fallback to original bytes if re-encoding fails.
                return $this->imageResponse($imageContent, $media->mime_type ?? 'application/octet-stream', $isVersioned);
            }

            Storage::put($cachePath, $output);
        }

        return $this->imageResponse($output, $mime, $isVersioned);
    }

    protected function ratelimit(Request $request, string $path): void
    {
        $allowed = RateLimiter::attempt(
            key: 'img:' . $request->ip() . ':' . $path,
            maxAttempts: 10, // More lenient for images
            // decay: 60,
            callback: fn (): true => true
        );

        if (! $allowed) {
            Log::warning("Rate limit exceeded for image: {$path}", ['ip' => $request->ip()]);
            throw new HttpResponseException(
                response('Too Many Requests', 429)->header('Retry-After', '60')
            );
        }
    }

    /**
     * Load raw image bytes from the storage disk or the original URL.
     */
    private function loadSource(Media $media, string $path): string
    {
        $diskPath = $media->file_path ?? $media->file_name;

        try {
            if (Storage::exists($diskPath)) {
                $content = Storage::get($diskPath);
            } elseif (! empty($media->original_url)) {
                $content = Http::timeout(5)->get($media->original_url)->throw()->body();
            } else {
                throw new Exception('No valid image source found');
            }

            if (empty($content)) {
                throw new Exception('Empty image source');
            }

            return $content;
        } catch (Exception $e) {
            Log::error("Failed to load image: {$path}", ['exception' => $e->getMessage()]);
            abort(404);
        }
    }

    /**
     * Resolve "{id}/{file_name}". File names alone are not unique across media,
     * so the id is required and the name must match it.
     */
    private function findMedia(string $path): ?Media
    {
        if (preg_match('#^(\d+)/([^/]+)$#', $path, $matches) !== 1) {
            return null;
        }

        return Media::query()
            ->whereKey((int) $matches[1])
            ->where('file_name', $matches[2])
            ->first();
    }

    /**
     * Only a URL carrying the current media version is safe to cache as
     * immutable; anything else may change in place and gets a short lifetime.
     */
    private function imageResponse(string $output, string $mime, bool $isVersioned): Response
    {
        $cacheControl = $isVersioned
            ? 'public, max-age=' . self::CACHE_DURATION . ', immutable'
            : 'public, max-age=' . self::UNVERSIONED_CACHE_DURATION;

        return response($output, 200)
            ->header('Content-Type', $mime)
            ->header('Content-Length', (string) mb_strlen($output, '8bit'))
            ->header('Cache-Control', $cacheControl)
            // The format is negotiated from Accept, so shared caches must key on it.
            ->header('Vary', 'Accept')
            ->header('X-Content-Type-Options', 'nosniff');
    }

    /**
     * @return array{0: string, 1: GifEncoder|JpegEncoder|PngEncoder|WebpEncoder}
     */
    private function encoderFor(string $format): array
    {
        return match ($format) {
            'png' => ['image/png', new PngEncoder],
            'gif' => ['image/gif', new GifEncoder],
            'jpeg' => ['image/jpeg', new JpegEncoder(quality: self::QUALITY, strip: true)],
            default => ['image/webp', new WebpEncoder(quality: self::QUALITY, strip: true)],
        };
    }

    private function determineFormat(Request $request, Media $media): string
    {
        // Check Accept header for WebP support
        if (str_contains($request->header('Accept', ''), 'image/webp')) {
            return 'webp';
        }

        // Fall back to original format if available
        if (! empty($media->mime_type)) {
            $ext = explode('/', $media->mime_type)[1] ?? '';
            $ext = $ext === 'jpg' ? 'jpeg' : $ext; // normalize to encoder key

            return in_array($ext, ['png', 'gif', 'jpeg', 'webp'], true) ? $ext : 'webp';
        }

        return 'webp';
    }
}
