<?php

declare(strict_types=1);

namespace App\Observers;

use App\Actions\PurgeCache;
use App\Models\ProjectTechnology;

final class ProjectTechnologyObserver
{
    public function created(): void
    {
        PurgeCache::handle(ProjectTechnology::class);
    }

    public function updated(): void
    {
        PurgeCache::handle(ProjectTechnology::class);
    }

    public function deleted(): void
    {
        PurgeCache::handle(ProjectTechnology::class);
    }
}
