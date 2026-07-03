<?php

declare(strict_types=1);

namespace App\Actions;

use Illuminate\Support\Facades\Cache;

final class PurgeCache
{
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
    public const TTL = 21600; // 6 hours

    /**
     * @var list<string>
     */
    private const KEYS = [
        'jobs',
        'technologies',
        'jobs_with_projects_technologies',
        'jobs_with_projects_technologies_and_media',
    ];

    public static function handle(): void
    {
        foreach (self::KEYS as $key) {
            // Forget both the current versioned key and the legacy unversioned one.
            Cache::forget($key . self::VERSION);
            Cache::forget($key);
        }
    }
}
