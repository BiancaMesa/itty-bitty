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
    // Route::get('/dashboard', [ShortUrlController::class, 'index'])->name('dashboard');
    // Route::post('/urls', [ShortUrlController::class, 'store'])->name('urls.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/shorten-url', [ShortUrlController::class, 'short'])->name('short.url');
Route::get('/{code}', [ShortUrlController::class, 'show'])->name('short.show');
// Route::get('/short-url-key/{shortUrlKey}', [ShortUrlController::class, 'show'])->name('redirect.url');

// Route::get('/test-flash', function () {
//     session()->flash('shortenedUrl', 'https://example.com');
//     return redirect()->route('dashboard');
// });

//testing 
// Route::get('/set-session', function (Request $request) {
//     $request->session()->put('test_key', 'test_value');
//     return 'Session set';
// });

// Route::get('/get-session', function (Request $request) {
//     return $request->session()->get('test_key', 'No session value found');
// });


require __DIR__.'/auth.php';
