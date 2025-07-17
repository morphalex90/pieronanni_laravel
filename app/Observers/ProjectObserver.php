<?php

namespace App\Observers;

use App\Actions\PurgeCache;
use App\Models\Project;

class ProjectObserver
{
    public function created(): void
    {
        PurgeCache::handle();
    }

    public function updated(): void
    {
        PurgeCache::handle();
    }

    public function deleting(Project $project): void
    {
        $project->technologies()->detach();
        $project->media()->delete();
    }

    public function deleted(): void
    {
        PurgeCache::handle();
    }
}
