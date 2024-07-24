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

        // // Get the latest full shortened URL
        $latestFullShortenedUrl = $user->getLastFullShortenedUrl();

        return Inertia::render('Dashboard', [
            'shortUrls' => $shortUrls, //We pass all URLs
            'latestFullShortenedUrl' => $latestFullShortenedUrl, // we pass the latest URL to the view
            'shortenedUrl' => session('shortenedUrl'),
        ]);
    }

    // Function to shorten a URL from the given original one  
    public function short(ShortRequest $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'original_url' => 'required|url',
        ]);

        // We check if there is a shortened URL already created for the original URL
        // $existingShortUrl = ShortUrl::where('original_url', $request->original_url)
        // ->where('user_id', auth()->id())
        // ->first();

        // if ($existingShortUrl) {
        //     return Inertia::render('Dashboard', [
        //         'shortenedUrl' => $existingShortUrl->full_shortened_url,
        //         'shortUrlId' => $existingShortUrl->id,
        //     ]);
        // } else {
        //     $shortUrlKey = Str::random(6);
        //     $fullShortenedUrl = url('/' . $shortUrlKey);
    
        //     // Create a new short URL entry
        //     $shortUrl = ShortUrl::create([
        //         'user_id' => auth()->id(), // Associate with the logged-in user
        //         'title' => $request->title, 
        //         'original_url' => $request->original_url,
        //         'short_url_key' => $shortUrlKey,
        //         'full_shortened_url' => $fullShortenedUrl, 
        //     ]);

        //     return Inertia::render('Dashboard', [
        //         'shortenedUrl' => $fullShortenedUrl,
        //         'shortUrlId' => $shortUrl->id,
        //     ]);
        // }

                // Generate a unique short URL key
                $shortUrlKey = Str::random(6);
                $fullShortenedUrl = url('/' . $shortUrlKey);
        
                // Create a new short URL entry
                $shortUrl = ShortUrl::create([
                    'user_id' => auth()->id(), // Associate with the logged-in user
                    'title' => $request->title,
                    'original_url' => $request->original_url,
                    'short_url_key' => $shortUrlKey,
                    'full_shortened_url' => $fullShortenedUrl,
                ]);
        
                return Inertia::render('Dashboard', [
                    'shortenedUrl' => $fullShortenedUrl,
                    'shortUrlId' => $shortUrl->id,
                ]);
        
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
    $shortUrl = ShortUrl::findOrFail($id);

    // Ensure the user is authorized to delete this URL
    if ($shortUrl->user_id !== auth()->id()) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    $shortUrl->delete();

    return response()->noContent(); // Returns no content for successful delete
    }

    public function manageUrls()
    {
        $user = auth()->user();
        $shortUrls = ShortUrl::where('user_id', $user->id)->get();
        return Inertia::render('ManageUrls', [
            'shortUrls' => $shortUrls,
        ]);
    }

    public function analytics()
    {
        $user = auth()->user();
        $shortUrls = ShortUrl::where('user_id', $user->id)->get(['title', 'original_url', 'full_shortened_url', 'clicks']);

        return Inertia::render('Analytics', [
            'shortUrls' => $shortUrls,
        ]);
    }
}