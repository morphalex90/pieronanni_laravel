<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\JobObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(JobObserver::class)]
final class Job extends Model
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

        $diff = $date_start->diff($date_end);
        $years = $diff->y;
        $months = $diff->m;

        if ($years > 0) {
            $yearStr = $years === 1 ? '1 year' : $years . ' years';
            $monthStr = $months === 1 ? '1 month' : $months . ' months';

            return $yearStr . ', ' . $monthStr;
        }

        return $months === 1 ? '1 month' : $months . ' months';

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
