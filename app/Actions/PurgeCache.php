<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Job;
use App\Models\Media;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Support\Facades\Cache;

final class PurgeCache
{
    public const JOBS = 'jobs';

    public const TECHNOLOGIES = 'technologies';

    public const JOBS_WITH_PROJECTS_TECHNOLOGIES = 'jobs_with_projects_technologies';

    public const JOBS_WITH_PROJECTS_TECHNOLOGIES_AND_MEDIA = 'jobs_with_projects_technologies_and_media';

    /**
     * Suffix appended to every model cache key. Bump this whenever the cached
     * model shape changes so stale, incompatible serialized payloads left in a
     * forever cache (e.g. from a previous deploy) are abandoned instead of read.
     */
    public const VERSION = ':v2';

    /**
     * TTL (seconds) for cached model payloads. A bounded lifetime lets a bad
     * fill (e.g. an empty collection cached during a deploy/replica-lag race)
     * self-heal instead of being stuck forever, as it was under rememberForever.
     */
    public const TTL = 2592000; // 1 month

    /**
     * Cache keys whose payload embeds each model, keyed by model class.
     * Purging only the affected keys avoids evicting unrelated warm entries
     * every time any observed model is touched.
     *
     * @var array<class-string, list<string>>
     */
    private const KEYS_BY_MODEL = [
        Job::class => [
            self::JOBS,
            self::JOBS_WITH_PROJECTS_TECHNOLOGIES,
            self::JOBS_WITH_PROJECTS_TECHNOLOGIES_AND_MEDIA,
        ],
        Technology::class => [
            self::TECHNOLOGIES,
            self::JOBS_WITH_PROJECTS_TECHNOLOGIES,
            self::JOBS_WITH_PROJECTS_TECHNOLOGIES_AND_MEDIA,
        ],
        Project::class => [
            self::JOBS_WITH_PROJECTS_TECHNOLOGIES,
            self::JOBS_WITH_PROJECTS_TECHNOLOGIES_AND_MEDIA,
        ],
        Media::class => [
            self::JOBS_WITH_PROJECTS_TECHNOLOGIES_AND_MEDIA,
        ],
    ];

    /**
     * Purge every cache key affected by a change to the given model class.
     *
     * @param  class-string  $model
     */
    public static function handle(string $model): void
    {
        self::forget(self::KEYS_BY_MODEL[$model] ?? []);
    }

    /**
     * Purge every model cache key.
     */
    public static function all(): void
    {
        self::forget(array_keys(self::allKeys()));
    }

    /**
     * Resolve the versioned cache key for an unversioned base key.
     */
    public static function key(string $key): string
    {
        return $key . self::VERSION;
    }

    /**
     * @param  list<string>  $keys
     */
    private static function forget(array $keys): void
    {
        foreach ($keys as $key) {
            // Forget both the current versioned key and the legacy unversioned one.
            Cache::forget(self::key($key));
            Cache::forget($key);
        }
    }

    /**
     * @return array<string, true>
     */
    private static function allKeys(): array
    {
        $keys = [];

        foreach (self::KEYS_BY_MODEL as $modelKeys) {
            foreach ($modelKeys as $key) {
                $keys[$key] = true;
            }
        }

        return $keys;
    }
}
