<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\MediaObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

// https://github.com/spatie/laravel-medialibrary/issues/75

#[ObservedBy(MediaObserver::class)]
final class Media extends BaseMedia
{
    /**
     * All the relationships to be touched.
     *
     * @var list<string>
     */
    protected $touches = ['model'];

    protected $appends = [
        'url',
        'thumbnail_url',
    ];

    /**
     * Versioned URL for the image route; safe to cache as immutable because it
     * changes whenever the media row does.
     */
    public function imageRouteUrl(?string $size = null): string
    {
        return route('image.show', [
            'path' => $this->getKey() . '/' . $this->file_name,
            ...($size !== null ? ['size' => $size] : []),
            'v' => $this->imageVersion(),
        ]);
    }

    /**
     * Token identifying the current bytes of this media.
     */
    public function imageVersion(): string
    {
        return (string) ($this->updated_at?->getTimestamp() ?? 0);
    }

    /**
     * Served through the image route so visitors get re-encoded WebP instead
     * of the raw upload.
     */
    protected function getUrlAttribute(): string
    {
        return $this->imageRouteUrl();
    }

    protected function getThumbnailUrlAttribute(): string
    {
        return $this->imageRouteUrl('thumb');
    }
}
