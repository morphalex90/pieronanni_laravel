<?php

namespace App\Actions;

use Illuminate\Support\Facades\Cache;

class PurgeCache
{
    public static function handle(): void
    {
        Cache::forget('jobs');
        Cache::forget('technologies');
        Cache::forget('jobs_with_projects_technologies');
        Cache::forget('jobs_with_projects_technologies_and_files');
    }
}
