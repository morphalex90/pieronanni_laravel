<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Encoders\GifEncoder;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\Laravel\Facades\Image;

class ImageController extends Controller
{
    private const CACHE_DURATION = 31536000; // 1 year

    public function show(Request $request, string $path)
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

        try {
            // Support both storage disk and direct URLs
            if (Storage::exists($media->file_path ?? $media->file_name)) {
                $image_content = Storage::get($media->file_path ?? $media->file_name);
            } elseif (! empty($media->original_url)) {
                $image_content = file_get_contents($media->original_url);
            } else {
                throw new Exception('No valid image source found');
            }

            $image = Image::read($image_content);
        } catch (Exception $e) {
            Log::error("Failed to load image: {$path}", ['exception' => $e->getMessage()]);
            abort(404);
        }

        try {
            $quality = 75; // Better quality
            $format = $this->determineFormat($request, $media);

            [$mime, $encoder] = match ($format) {
                'png' => ['image/png', new PngEncoder],
                'gif' => ['image/gif', new GifEncoder],
                'jpeg' => ['image/jpeg', new JpegEncoder(quality: $quality, strip: true)],
                default => ['image/webp', new WebpEncoder(quality: $quality, strip: true)],
            };

            $output = $image->encode($encoder);

            return response($output, 200)
                ->header('Content-Type', $mime)
                ->header('Content-Length', mb_strlen($output))
                ->header('Cache-Control', 'public, max-age=' . self::CACHE_DURATION . ', immutable')
                ->header('X-Content-Type-Options', 'nosniff');
        } catch (Exception $e) {
            Log::error("Failed to encode image: {$path}", ['exception' => $e->getMessage()]);

            // Fallback to original image if encoding fails
            try {
                return response($image_content, 200)
                    ->header('Content-Type', $media->mime_type ?? 'application/octet-stream')
                    ->header('Content-Length', mb_strlen($image_content))
                    ->header('Cache-Control', 'public, max-age=' . self::CACHE_DURATION . ', immutable')
                    ->header('X-Content-Type-Options', 'nosniff');
            } catch (Exception $fallbackError) {
                Log::error("Fallback to original image failed: {$path}", ['exception' => $fallbackError->getMessage()]);
                abort(500);
            }
        }
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
                response('Too Many Requests', 429)->header('Retry-After', 60)
            );
        }
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

            return in_array($ext, ['png', 'gif', 'jpeg', 'jpg', 'webp']) ? $ext : 'webp';
        }

        return 'webp';
    }
}
