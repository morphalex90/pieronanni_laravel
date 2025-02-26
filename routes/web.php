<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PDFController;
use App\Models\Job;
use App\Models\Technology;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('homepage');

Route::get('/about', function () {
    $jobs = Job::orderBy('started_at', 'DESC')->get();

    return Inertia::render('about', ['jobs' => $jobs]);
})->name('about');

Route::get('/projects', function () {
    $technologies = Technology::orderBy('name')->get();
    $jobs = Job::with('projects.technologies', 'projects.files')->orderBy('started_at', 'DESC')->get();

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
