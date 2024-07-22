<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\ShortUrl;

// class ShortUrlController extends Controller
// {
//     public function short(Request $request)
//     {
//         if($request->original_url) {
//             $new_url = ShortUrl::create([
//                 'original_url' => $request->original_url
//             ]);
//         }
//     }
// }



use Illuminate\Http\Request;
use App\Models\ShortUrl;
use Inertia\Inertia;
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{
    public function short(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url',
        ]);

        // Generate a unique short URL key
        $shortUrlKey = Str::random(6);

        // Create a new short URL entry
        $shortUrl = ShortUrl::create([
            'original_url' => $request->original_url,
            // 'short_url' => $shortUrlKey,
        ]);

        // return Inertia::render('Dashboard', [
        //     'shortenedUrl' => url($shortUrlKey),
        // ]);
    }

    // public function show($shortUrlKey)
    // {
    //     $shortUrl = ShortUrl::where('short_url', $shortUrlKey)->firstOrFail();
    //     $shortUrl->increment('visits');

    //     return redirect($shortUrl->original_url);
    // }
}