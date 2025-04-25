<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
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
        'filename',
        'alt',
        'delta',
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
            // return Storage::disk('backblaze')->url($this->uri);
            return '/' . $this->uri;
        }

        return $this->uri;
    }
}
