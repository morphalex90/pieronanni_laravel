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
     * @var array
     */
    protected $touches = ['model'];

    protected $appends = [
        'url',
    ];

    protected function getUrlAttribute(): string
    {
        return $this->original_url;
        // return '/media/' . $this->file_name;
    }
}
