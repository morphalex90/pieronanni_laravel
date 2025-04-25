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

    public function deleting(Project $project)
    {
        $project->technologies()->detach();
        $project->files()->delete();
    }

    public function deleted(): void
    {
        PurgeCache::handle();
    }
}
