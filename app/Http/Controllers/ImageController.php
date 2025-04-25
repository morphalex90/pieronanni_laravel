<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Encoders\GifEncoder;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\Laravel\Facades\Image;

class ImageController extends Controller
{
    public function show(Request $request, $environment, $path)
    {
        if (App::isProduction()) {
            $this->ratelimit($request, $path);
        }

        $quality = 50;
        $format = 'webp';

        $path = Storage::disk('backblaze')->url('files/' . $environment . '/' . $path);

        try {
            $image = file_get_contents($path);
        } catch (Exception $e) {
            abort(404);
        }

        $image = Image::read($image);

        [$mime, $encoder] = match (strtolower($format)) {
            'png' => ['image/png', new PngEncoder],
            'gif' => ['image/gif', new GifEncoder],
            'webp' => ['image/webp', new WebpEncoder(quality: $quality, strip: true)],
            default => ['image/jpeg', new JpegEncoder(quality: $quality, strip: true)],
        };

        return response($image->encode($encoder), 200)
            ->header('Content-Type', $mime)
            ->header('Cache-Control', 'public, max-age=2592000, s-maxage=2592000, immutable');
    }

    protected function ratelimit(Request $request, $path): void
    {
        $allowed = RateLimiter::attempt(
            key: 'img:' . $request->ip() . ':' . $path,
            maxAttempts: 2,
            callback: fn() => true
        );

        if (! $allowed) {
            abort(403);
        }
    }
}
