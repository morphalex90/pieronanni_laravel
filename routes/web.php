<?php

declare(strict_types=1);

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/projects', [PageController::class, 'projects'])->name('projects');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:contact')
    ->name('contact.store');

Route::middleware('throttle:pdf')->group(function (): void {
    Route::get('/cv', [PDFController::class, 'cv'])->name('cv');
    Route::get('/cv-old', [PDFController::class, 'cvOld'])->name('cv-old');
});

Route::get('/cv.pdf', function () {
    return redirect('/cv');
});

Route::get('/login', function () {
    return redirect('admin/login');
})->name('login');

Route::get('/media/{path}', [ImageController::class, 'show'])
    ->where('path', '.*')
    ->name('image.show');
