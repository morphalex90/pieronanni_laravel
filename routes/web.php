<?php

declare(strict_types=1);

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\SitemapController;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/projects', [PageController::class, 'projects'])->name('projects');
Route::get('/projects/{project:slug}', [PageController::class, 'project'])->name('projects.show');
Route::get('/freelance-laravel-developer-london', [PageController::class, 'freelance'])->name('freelance');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:contact')
    ->name('contact.store');

Route::middleware('throttle:pdf')->group(function (): void {
    Route::get('/cv', [PDFController::class, 'cv'])->name('cv');
    Route::get('/cv-old', [PDFController::class, 'cvOld'])->name('cv-old');
});

Route::permanentRedirect('/cv.pdf', '/cv');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::get('/login', function () {
    return redirect('admin/login');
})->name('login');

// Inertia would overwrite the response's `Vary: Accept` with `Vary: X-Inertia`.
Route::get('/media/{path}', [ImageController::class, 'show'])
    ->withoutMiddleware(HandleInertiaRequests::class)
    ->where('path', '.*')
    ->name('image.show');
