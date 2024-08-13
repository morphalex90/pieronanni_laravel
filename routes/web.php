<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PDFController;
use App\Models\Job;
use App\Models\Technology;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Homepage', []);
})->name('homepage');

Route::get('/about', function () {
    return Inertia::render('About', []);
})->name('about');

Route::get('/projects', function () {
    $technologies = Technology::orderBy('name')->get();
    $jobs = Job::with('projects.technologies')->orderBy('started_at', 'DESC')->get();
    return Inertia::render('Projects', ['technologies' => $technologies, 'allJobs' => $jobs]);
})->name('projects');

Route::get('/contact', function () {
    return Inertia::render('Contact', []);
})->name('contact');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/cv', [PDFController::class, 'cv'])->name('cv');

Route::get('/cv.pdf', function () {
    return redirect('/cv');
});

Route::get('/login', function () {
    return redirect('admin/login');
})->name('login');
