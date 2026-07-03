<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\ProjectObserver;
use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[ObservedBy(ProjectObserver::class)]
final class Project extends Model implements HasMedia
{
    /** @use HasFactory<ProjectFactory> */
    use HasFactory, InteractsWithMedia;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'job_id',
        'title',
        'url',
        'github',
        'description',
        'description_cv',
        'is_visible_in_cv',
        'published_at',
    ];

    /**
     * @return BelongsToMany<Technology, $this>
     */
    public function technologies(): BelongsToMany
    {
        return $this->belongsToMany(Technology::class);
    }

    /**
     * @return BelongsTo<Job, $this>
     */
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_visible_in_cv' => 'boolean',
        ];
    }
}
