<?php

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
})->name('homepage');

Route::get('/about', function () {
    $jobs = Cache::rememberForever('jobs', function () {
        return Job::orderBy('started_at', 'DESC')->get();
    });

    return Inertia::render('about', ['jobs' => $jobs]);
})->name('about');

Route::get('/projects', function () {
    $technologies = Cache::rememberForever('technologies', function () {
        return Technology::orderBy('name')->get();
    });

    $jobs = Cache::rememberForever('jobs_with_projects_technologies_and_files', function () {
        return Job::with('projects.technologies', 'projects.files')->orderBy('started_at', 'DESC')->get();
    });

    return Inertia::render('projects', ['technologies' => $technologies, 'allJobs' => $jobs]);
})->name('projects');

Route::get('/contact', function () {
    return Inertia::render('contact');
})->name('contact');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/cv', [PDFController::class, 'cv'])->name('cv');

Route::get('/cv.pdf', function () {
    return redirect('/cv');
});

Route::get('/login', function () {
    return redirect('admin/login');
})->name('login');

Route::get('/files/{environment}/{path}', [ImageController::class, 'show'])
    ->where('path', '.*')
    ->name('image.show');
