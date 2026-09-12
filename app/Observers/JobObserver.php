<?php

declare(strict_types=1);

namespace App\Observers;

use App\Actions\PurgeCache;
use App\Models\Job;

final class JobObserver
{
    public function created(): void
    {
        PurgeCache::handle(Job::class);
    }

    public function updated(): void
    {
        PurgeCache::handle(Job::class);
    }

    public function deleted(): void
    {
        PurgeCache::handle(Job::class);
    }
}
