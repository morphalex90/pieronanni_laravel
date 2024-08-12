<?php

use App\Http\Controllers\PDFController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Homepage', []);
});

Route::get('/about', function () {
    return Inertia::render('About', []);
});

Route::get('/projects', function () {
    return Inertia::render('Projects', []);
});

Route::get('/contact', function () {
    return Inertia::render('Contact', []);
});

Route::get('/cv', [PDFController::class, 'cv']);

Route::get('/cv.pdf', function () {
    return redirect('/cv');
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__ . '/auth.php';
