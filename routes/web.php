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

require __DIR__.'/auth.php';

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [ShortUrlController::class, 'index'])->name('dashboard');
    Route::post('/dashboard', [ShortUrlController::class, 'short'])->name('short.url');
    // //fetch the shortened URL
    // Route::get('/short-url/{id}/fetch', [ShortUrlController::class, 'fetch'])->name('short.url.fetch');
    
    Route::get('/manage-urls', [ShortUrlController::class, 'manageUrls'])->name('manage.urls'); 
    // Route for the user to delete a short URL
    Route::delete('/short-url/{id}', [ShortUrlController::class, 'destroy'])->name('short.url.delete');

    // Analytics: keep track of clicks 
    Route::get('/analytics', [ShortUrlController::class, 'analytics'])->name('analytics');
});

//Public route for shortened URL
Route::get('/{shortUrlKey}', [ShortUrlController::class, 'show'])->name('short.show');

 //fetch the shortened URL
 Route::get('/short-url/{id}/fetch', [ShortUrlController::class, 'fetch'])->name('short.url.fetch');



