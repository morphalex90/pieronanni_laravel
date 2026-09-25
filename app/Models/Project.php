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
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[ObservedBy(ProjectObserver::class)]
final class Project extends Model implements HasMedia
{
    /** @use HasFactory<ProjectFactory> */
    use HasFactory, InteractsWithMedia;

    /**
     * Descriptions shorter than this are too thin to be worth indexing as a
     * standalone page, so those project pages are noindexed and left out of the sitemap.
     */
    public const MIN_INDEXABLE_WORDS = 50;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'job_id',
        'title',
        'slug',
        'url',
        'github',
        'description',
        'description_cv',
        'is_visible_in_cv',
        'published_at',
    ];

    /**
     * Build a slug from the title that no other project uses yet.
     */
    public static function uniqueSlugFor(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'project';
        $slug = $base;

        for ($suffix = 2; self::query()->where('slug', $slug)->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))->exists(); $suffix++) {
            $slug = $base . '-' . $suffix;
        }

        return $slug;
    }

    /**
     * Whether the description carries enough content for the project page to be indexed.
     */
    public function isIndexable(): bool
    {
        return str_word_count(strip_tags((string) $this->description)) >= self::MIN_INDEXABLE_WORDS;
    }

    /**
     * @return BelongsToMany<Technology, $this, ProjectTechnology>
     */
    public function technologies(): BelongsToMany
    {
        return $this->belongsToMany(Technology::class)->using(ProjectTechnology::class);
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
