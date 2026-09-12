<?php

declare(strict_types=1);

use App\Actions\PurgeCache;
use App\Models\Job;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Support\Facades\Cache;

function warmAllCacheKeys(): void
{
    foreach ([
        PurgeCache::JOBS,
        PurgeCache::TECHNOLOGIES,
        PurgeCache::JOBS_WITH_PROJECTS_TECHNOLOGIES,
        PurgeCache::JOBS_WITH_PROJECTS_TECHNOLOGIES_AND_MEDIA,
    ] as $key) {
        Cache::put(PurgeCache::key($key), 'warm', PurgeCache::TTL);
    }
}

it('purges only the keys a job change affects', function () {
    warmAllCacheKeys();

    Job::factory()->create();

    expect(Cache::has(PurgeCache::key(PurgeCache::JOBS)))->toBeFalse()
        ->and(Cache::has(PurgeCache::key(PurgeCache::JOBS_WITH_PROJECTS_TECHNOLOGIES)))->toBeFalse()
        ->and(Cache::has(PurgeCache::key(PurgeCache::JOBS_WITH_PROJECTS_TECHNOLOGIES_AND_MEDIA)))->toBeFalse()
        ->and(Cache::has(PurgeCache::key(PurgeCache::TECHNOLOGIES)))->toBeTrue();
});

it('purges only the keys a technology change affects', function () {
    warmAllCacheKeys();

    Technology::factory()->create();

    expect(Cache::has(PurgeCache::key(PurgeCache::TECHNOLOGIES)))->toBeFalse()
        ->and(Cache::has(PurgeCache::key(PurgeCache::JOBS_WITH_PROJECTS_TECHNOLOGIES)))->toBeFalse()
        ->and(Cache::has(PurgeCache::key(PurgeCache::JOBS_WITH_PROJECTS_TECHNOLOGIES_AND_MEDIA)))->toBeFalse()
        ->and(Cache::has(PurgeCache::key(PurgeCache::JOBS)))->toBeTrue();
});

it('leaves the standalone job and technology lists warm when a project changes', function () {
    $job = Job::factory()->create();

    warmAllCacheKeys();

    Project::factory()->for($job)->create();

    expect(Cache::has(PurgeCache::key(PurgeCache::JOBS_WITH_PROJECTS_TECHNOLOGIES)))->toBeFalse()
        ->and(Cache::has(PurgeCache::key(PurgeCache::JOBS_WITH_PROJECTS_TECHNOLOGIES_AND_MEDIA)))->toBeFalse()
        ->and(Cache::has(PurgeCache::key(PurgeCache::JOBS)))->toBeTrue()
        ->and(Cache::has(PurgeCache::key(PurgeCache::TECHNOLOGIES)))->toBeTrue();
});

it('purges every key when asked for a full purge', function () {
    warmAllCacheKeys();

    PurgeCache::all();

    expect(Cache::has(PurgeCache::key(PurgeCache::JOBS)))->toBeFalse()
        ->and(Cache::has(PurgeCache::key(PurgeCache::TECHNOLOGIES)))->toBeFalse()
        ->and(Cache::has(PurgeCache::key(PurgeCache::JOBS_WITH_PROJECTS_TECHNOLOGIES)))->toBeFalse()
        ->and(Cache::has(PurgeCache::key(PurgeCache::JOBS_WITH_PROJECTS_TECHNOLOGIES_AND_MEDIA)))->toBeFalse();
});
