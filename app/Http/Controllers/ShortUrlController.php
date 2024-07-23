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

        // Get the latest full shortened URL
        $latestFullShortenedUrl = $user->getLastFullShortenedUrl();

        return Inertia::render('Dashboard', [
            'shortUrls' => $shortUrls, //We pass all URLs
            'latestFullShortenedUrl' => $latestFullShortenedUrl, // we pass the latest URL to the view
        ]);
    }

    // Function to shorten a URL from the given original one  
    public function short(ShortRequest $request)
    {
        $request->validate([
            'original_url' => 'required|url',
        ]);

        $shortUrlKey = Str::random(6);

        $fullShortenedUrl = url('/' . $shortUrlKey);

        // Create a new short URL entry
        $shortUrl = ShortUrl::create([
            'user_id' => auth()->id(), // Associate with the logged-in user
            'original_url' => $request->original_url,
            'short_url_key' => $shortUrlKey,
            'full_shortened_url' => $fullShortenedUrl, 
        ]);

        return redirect()->route('dashboard')->with([
            'shortenedUrl' => $fullShortenedUrl, 
        ]);

        // AJAX request to submit the form 
        // return response()->json([
        //     'shortenedUrl' => $fullShortenedUrl
        // ]);
    }

    // Function to show the user the shortened url  
    public function show($shortUrlKey)
    {
        // Find the short URL record
        $shortUrl = ShortUrl::where('short_url_key', $shortUrlKey)->firstOrFail();

        // Increment the click count
        $shortUrl->increment('clicks');

        // Redirect to the original URL
        return redirect()->to($shortUrl->original_url);
    }

    public function destroy($id)
    {
        $shortUrl = ShortUrl::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $shortUrl->delete();

        return response()->json(['message' => 'Short URL deleted successfully.']);
    }
}