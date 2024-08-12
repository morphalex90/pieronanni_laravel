<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ProfileController;
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
    return Inertia::render('Projects', ['technologies' => $technologies]);
})->name('projects');

Route::get('/contact', function () {
    return Inertia::render('Contact', []);
})->name('contact');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/cv', [PDFController::class, 'cv'])->name('cv');

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
