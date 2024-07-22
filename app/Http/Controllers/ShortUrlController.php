<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortRequest;
use App\Models\ShortUrl;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ShortUrlController extends Controller
{
    public function index()
    {
        // Display the user's short URLs on the dashboard
        $user = auth()->user();
        $shortUrls = ShortUrl::where('user_id', $user->id)->get();

        return Inertia::render('Dashboard', [
            'shortUrls' => $shortUrls, //We pass all URLs
        ]);
    }

    // FUNCTION TO SHORTEN THE URL FROM THE GIVEN ORIGINAL URL
    public function short(ShortRequest $request)
    {
        // We validate the input URL
        $request->validate([
            'original_url' => 'required|url',
        ]);

        // Generate a unique short URL key
        $shortUrlKey = Str::random(6);

        // Create a new short URL entry
        $shortUrl = ShortUrl::create([
            'user_id' => auth()->id(), // Associate with the logged-in user
            'original_url' => $request->original_url,
            'short_url' => $shortUrlKey,
        ]);

        // Build the full shortened URL
        //$shortenedUrl = url('/itty-bitty/' . $shortUrlKey);
        //$shortenedUrl = url('http://itty-bitty/' . $shortUrlKey);
        // $baseurl = url('http://itty-bitty/');
        // $shortenedUrl = url('/' . $baseurl . $shortUrlKey);
        $shortenedUrl = url('/' . $shortUrlKey);

        // Return JSON response for AJAX
        // if ($request->expectsJson()) {
        //     return response()->json([
        //         'shortenedUrl' => $shortenedUrl,
        //         'successMessage' => 'Your Short URL: ' . $shortenedUrl,
        //     ]);
        // }

        //Return Inertia response with the shortened URL
        return Inertia::render('Dashboard', [
            'shortUrls' => ShortUrl::where('user_id', auth()->id())->get(),
            'shortenedUrl' => $shortenedUrl,
            'successMessage' => 'Your Short URL: ' . $shortenedUrl,
        ]);
    }

    // FUNCTION TO SHOW THE USER THE SHORTENED URL 
    public function show($shortUrlKey)
    {
        // Find the short URL record
        $shortUrl = ShortUrl::where('short_url', $shortUrlKey)->firstOrFail();

        // Increment the click count
        $shortUrl->increment('clicks');

        // Redirect to the original URL
        return redirect()->to($shortUrl->original_url);
    }
}