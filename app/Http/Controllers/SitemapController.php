<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Response;

final class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = [
            url('/') . '/',
            route('about'),
            route('projects'),
            route('freelance'),
            route('contact'),
            route('cv'),
        ];

        $projectUrls = Project::query()
            ->orderByDesc('published_at')
            ->get(['id', 'slug', 'description'])
            ->filter(fn (Project $project): bool => $project->isIndexable())
            ->map(fn (Project $project): string => route('projects.show', $project));

        return response()
            ->view('sitemap', ['urls' => [...$urls, ...$projectUrls]])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
