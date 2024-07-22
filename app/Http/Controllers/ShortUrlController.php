<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortRequest;
use App\Models\ShortUrl;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ShortUrlController extends Controller
{
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
        $shortenedUrl = url('/' . $shortUrlKey);

        

        //This one changes the link of the browser from /dashboard to /shorten-url
        // return Inertia::render('Dashboard', [
        //     'shortenedUrl' => url('/short-url-key/' . $shortUrlKey),
        // ]);
        // return Inertia::render('Dashboard', [
        //     'shortenedUrl' => url($shortUrlKey),
        // ]);

        // return redirect()->route('dashboard')->with('shortenedUrl', url($shortUrlKey));

        //Return Inertia response with the shortened URL
        return Inertia::render('Dashboard', [
            'shortenedUrl' => $shortenedUrl,
            'successMessage' => 'Your Short URL: ' . $shortenedUrl,
        ]);
    }

    // FUNCTION TO SHOW THE USER THE SHORTENED URL WE HAVE CREATED
    // public function show($code)
    // {
    //     $shortUrl = ShortUrl::where('short_url', $code)->firstOrFail();
    //     $shortUrl->increment('visits');

    //     return redirect($shortUrl->original_url);
    // }

    // public function show($shortUrlKey)
    // {
    //    dd($shortUrlKey);
    // }

    // public function show($shortUrlKey)
    // {
    //     $shortUrl = ShortUrl::where('short_url', $shortUrlKey)->firstOrFail();
    //     $shortUrl->increment('visits');

    //     return redirect($shortUrl->original_url);
    // }

    public function show($shortUrlKey)
    {
        // Find the short URL record
        $shortUrl = ShortUrl::where('short_url', $shortUrlKey)->firstOrFail();

        // Increment the click count
        $shortUrl->increment('clicks');

        // Redirect to the original URL
        return redirect($shortUrl->original_url);
    }
}