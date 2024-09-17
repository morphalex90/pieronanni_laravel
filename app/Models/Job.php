<?php

namespace App\Models;

use Carbon\Carbon;
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
     * @var array<int, string>
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

    /**
     * The calculated fields.
     *
     * @var array
     */
    protected $appends = [
        'duration',
    ];

    /**
     * Get the projects associated with the job.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class)->orderBy('published_at', 'DESC');
    }

    /**
     *  Duration
     */
    public function getDurationAttribute()
    {
        if ($this->ended_at == null) {
            return null;
        }

        $date_end = Carbon::parse($this->ended_at);
        $date_start = Carbon::parse($this->started_at);

        $format = (int)$date_start->diffInYears($date_end) > 0 ? '%y years, %m months' : '%m months';
        return $date_start->diff($date_end)->format($format);
    }
}
