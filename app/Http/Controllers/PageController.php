<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\PurgeCache;
use App\Models\Job;
use App\Models\Technology;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use Inertia\Response;

final class PageController extends Controller
{
    public function home(): Response
    {
        return Inertia::render('welcome');
    }

    public function about(): Response
    {
        $jobs = Cache::remember(PurgeCache::key(PurgeCache::JOBS), PurgeCache::TTL, function () {
            return Job::query()->orderBy('started_at', 'desc')->get();
        });

        return Inertia::render('about', ['jobs' => $jobs]);
    }

    public function projects(): Response
    {
        $technologies = Cache::remember(PurgeCache::key(PurgeCache::TECHNOLOGIES), PurgeCache::TTL, function () {
            return Technology::query()->orderBy('name')->get();
        });

        $jobs = Cache::remember(PurgeCache::key(PurgeCache::JOBS_WITH_PROJECTS_TECHNOLOGIES_AND_MEDIA), PurgeCache::TTL, function () {
            return Job::query()->with('projects.technologies', 'projects.media')->orderBy('started_at', 'desc')->get();
        });

        return Inertia::render('projects', ['technologies' => $technologies, 'allJobs' => $jobs]);
    }

    public function contact(): Response
    {
        return Inertia::render('contact');
    }
}
