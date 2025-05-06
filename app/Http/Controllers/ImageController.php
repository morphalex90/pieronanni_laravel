<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\Encoders\GifEncoder;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\Laravel\Facades\Image;

class ImageController extends Controller
{
    public function show(Request $request, $path)
    {
        if (App::isProduction()) {
            $this->ratelimit($request, $path);
        }

        $quality = 50;
        $format = 'webp';

        $media = Media::where('file_name', $path)->first();
        if ($media == null) {
            abort(404);
        }

        try {
            $loaded_image = file_get_contents($media->original_url);
        } catch (Exception $e) {
            abort(404);
        }

        $image = Image::read($loaded_image);

        [$mime, $encoder] = match (strtolower($format)) {
            // 'png' => ['image/png', new PngEncoder],
            // 'gif' => ['image/gif', new GifEncoder],
            'webp' => ['image/webp', new WebpEncoder(quality: $quality, strip: true)],
            // default => ['image/jpeg', new JpegEncoder(quality: $quality, strip: true)],
        };

        $output = $image->encode($encoder);

        return response($output, 200)
            ->header('Content-Type', $mime)
            ->header('Content-Length', strlen($output))
            ->header('Cache-Control', 'public, max-age=31536000, s-maxage=31536000, immutable');
    }

    protected function ratelimit(Request $request, $path): void
    {
        $allowed = RateLimiter::attempt(
            key: 'img:' . $request->ip() . ':' . $path,
            maxAttempts: 2,
            callback: fn() => true
        );

        if (! $allowed) {
            $media = Media::where('file_name', $path)->first();
            if ($media == null) {
                abort(404);
            }

            throw new HttpResponseException(Redirect::to($media->original_url));
        }
    }
}
