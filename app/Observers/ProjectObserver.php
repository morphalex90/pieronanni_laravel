<?php

declare(strict_types=1);

namespace App\Observers;

use App\Actions\PurgeCache;
use App\Models\Project;

final class ProjectObserver
{
    public function creating(Project $project): void
    {
        $project->is_visible_in_cv = true;
    }

    public function saving(Project $project): void
    {
        if (blank($project->slug)) {
            $project->slug = Project::uniqueSlugFor($project->title, $project->getKey());
        }
    }

    public function created(): void
    {
        PurgeCache::handle(Project::class);
    }

    public function updated(): void
    {
        PurgeCache::handle(Project::class);
    }

    public function deleting(Project $project): void
    {
        $project->technologies()->detach();
        $project->media()->delete();
    }

    public function deleted(): void
    {
        PurgeCache::handle(Project::class);
    }
}
