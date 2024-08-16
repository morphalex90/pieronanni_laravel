<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fileable_type',
        'fileable_id',
        'uri',
    ];

    /**
     * The calculated fields.
     *
     * @var array
     */
    protected $appends = [
        'url',
    ];

    /**
     * Get the parent imageable model (user or post).
     */
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getUrlAttribute()
    {
        if ($this->uri != null) {

            return Cache::tags('images')->remember('img:' . $this->uri, 3600, function () { // generate 1 hour image link and cache it for 1 hour
                return Storage::disk('backblaze')->temporaryUrl($this->uri, now()->addHours(1));
            });
        }

        return $this->uri;
    }
}
