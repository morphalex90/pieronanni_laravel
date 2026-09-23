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
    ];

    /**
     * Versioned URL for the image route; safe to cache as immutable because it
     * changes whenever the media row does.
     */
    public function imageRouteUrl(): string
    {
        return route('image.show', [
            'path' => $this->getKey() . '/' . $this->file_name,
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

    protected function getUrlAttribute(): string
    {
        return $this->original_url;
        // return '/media/' . $this->file_name;
    }
}
