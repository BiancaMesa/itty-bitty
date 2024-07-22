<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShortUrlController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'shortenedUrl' => session('shortenedUrl')
        //'shortenedUrl' => url('/short-url-key/' . $shortUrlKey)
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [ShortUrlController::class, 'index'])->name('dashboard');
    Route::post('/shorten-urls', [ShortUrlController::class, 'short'])->name('short.url');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/{shortUrlKey}', [ShortUrlController::class, 'show'])->name('short.show');
});

Route::post('/shorten-url', [ShortUrlController::class, 'short'])->name('short.url');
Route::get('/{shortUrlKey}', [ShortUrlController::class, 'show'])->name('short.show');


require __DIR__.'/auth.php';
