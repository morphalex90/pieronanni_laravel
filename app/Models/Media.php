<?php

namespace App\Models;

use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

// https://github.com/spatie/laravel-medialibrary/issues/75

class Media extends BaseMedia
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

    public function getUrlAttribute()
    {
        return '/media/' . $this->file_name;
    }
}
