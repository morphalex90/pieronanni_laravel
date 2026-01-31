<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'company',
        'location',
        'description',
        'description_cv',
        'started_at',
        'ended_at',
    ];

    /**
     * The calculated fields.
     *
     * @var list<string>
     */
    protected $appends = [
        'duration',
    ];

    /**
     * Get the projects associated with the job.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class)->latest('published_at');
    }

    /**
     *  Duration
     */
    protected function getDurationAttribute(): ?string
    {
        if ($this->ended_at === null) {
            return null;
        }

        $date_end = \Illuminate\Support\Facades\Date::parse($this->ended_at);
        $date_start = \Illuminate\Support\Facades\Date::parse($this->started_at);

        $format = (int) $date_start->diffInYears($date_end) > 0 ? '%y years, %m months' : '%m months';

        return $date_start->diff($date_end)->format($format);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'company' => 'array',
        ];
    }
}
