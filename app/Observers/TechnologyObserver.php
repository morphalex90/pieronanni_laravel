<?php

declare(strict_types=1);

namespace App\Observers;

use App\Actions\PurgeCache;
use App\Models\Technology;

final class TechnologyObserver
{
    public function created(): void
    {
        PurgeCache::handle(Technology::class);
    }

    public function updated(): void
    {
        PurgeCache::handle(Technology::class);
    }

    public function deleted(): void
    {
        PurgeCache::handle(Technology::class);
    }
}
