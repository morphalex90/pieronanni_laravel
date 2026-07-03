<?php

declare(strict_types=1);

use App\Actions\PurgeCache;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PDFController;
use App\Models\Job;
use App\Models\Technology;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::get('/about', function () {
    $jobs = Cache::remember('jobs' . PurgeCache::VERSION, PurgeCache::TTL, function () {
        return Job::query()->orderBy('started_at', 'desc')->get();
    });

    return Inertia::render('about', ['jobs' => $jobs]);
})->name('about');

Route::get('/projects', function () {
    $technologies = Cache::remember('technologies' . PurgeCache::VERSION, PurgeCache::TTL, function () {
        return Technology::query()->orderBy('name')->get();
    });

    $jobs = Cache::remember('jobs_with_projects_technologies_and_media' . PurgeCache::VERSION, PurgeCache::TTL, function () {
        return Job::query()->with('projects.technologies', 'projects.media')->orderBy('started_at', 'desc')->get();
    });

    return Inertia::render('projects', ['technologies' => $technologies, 'allJobs' => $jobs]);
})->name('projects');

Route::get('/contact', function () {
    return Inertia::render('contact');
})->name('contact');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/cv', [PDFController::class, 'cv'])->name('cv');
Route::get('/cv-old', [PDFController::class, 'cvOld'])->name('cv-old');

Route::get('/cv.pdf', function () {
    return redirect('/cv');
});

Route::get('/login', function () {
    return redirect('admin/login');
})->name('login');

Route::get('/media/{path}', [ImageController::class, 'show'])
    ->where('path', '.*')
    ->name('image.show');
