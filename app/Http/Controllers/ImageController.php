<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Media;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
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
    private const CACHE_DURATION = 31536000; // 1 year

    private const QUALITY = 75;

    public function show(Request $request, string $path): Response
    {
        if (App::isProduction()) {
            $this->ratelimit($request, $path);
        }

        try {
            $media = Media::where('file_name', $path)->firstOrFail();
        } catch (Exception $e) {
            Log::warning("Media not found: {$path}", ['exception' => $e->getMessage()]);
            abort(404);
        }

        $format = $this->determineFormat($request, $media);

        // Encoded output is immutable per (path, format) — cache it so we
        // decode+re-encode once instead of on every request.
        $cacheKey = "img:encoded:{$path}:{$format}";

        [$output, $mime] = Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($media, $path, $format) {
            $image_content = $this->loadSource($media, $path);
            $image = Image::decode($image_content);

            [$mime, $encoder] = match ($format) {
                'png' => ['image/png', new PngEncoder],
                'gif' => ['image/gif', new GifEncoder],
                'jpeg' => ['image/jpeg', new JpegEncoder(quality: self::QUALITY, strip: true)],
                default => ['image/webp', new WebpEncoder(quality: self::QUALITY, strip: true)],
            };

            try {
                return [(string) $image->encode($encoder), $mime];
            } catch (Exception $e) {
                Log::error("Failed to encode image: {$path}", ['exception' => $e->getMessage()]);

                // Fallback to original bytes if re-encoding fails.
                return [$image_content, $media->mime_type ?? 'application/octet-stream'];
            }
        });

        return $this->imageResponse($output, $mime);
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

    private function imageResponse(string $output, string $mime): Response
    {
        return response($output, 200)
            ->header('Content-Type', $mime)
            ->header('Content-Length', (string) mb_strlen($output, '8bit'))
            ->header('Cache-Control', 'public, max-age=' . self::CACHE_DURATION . ', immutable')
            ->header('X-Content-Type-Options', 'nosniff');
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
