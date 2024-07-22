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
        //If there is a new url that the user has inserted, we create a new url with the create method and collect it in the $new_url variable.
        // if($request->original_url) {
        //     $new_url = ShortUrl::create([
        //         'original_url' => $request->original_url
        //     ]);

                //If a $new_url variable has been created, we create a $short_url variable with the base_convert method. Then we update the $new_url with the $short_url. 
        //     if($new_url) {
        //         $short_url = base_convert($new_url->id, 10,36);
        //         $new_url->update([
        //             'short_url' => $short_url
        //         ]);

        //         return back();
        //     }
        // }
        // return back();


        // We validate 
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
        $shortenedUrl = url('/itty-bitty/' . $shortUrlKey);

        // $shortenedUrl = url('/short-url-key/' . $shortUrlKey);
        // Log::info('Shortened URL', ['shortenedUrl' => $shortenedUrl]);
    
        // // Store the shortened URL in the session
        // $request->session()->flash('shortenedUrl', $shortenedUrl);

        
        // Store the shortened URL in the session
        // $request->session()->flash('shortenedUrl', url('/itty-bitty/' . $shortUrlKey));

        // Debug session data
        // dd($request->session()->all());

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

        // Redirect back to the dashboard
        //return redirect()->route('dashboard');
        // return redirect()->back()->with('success_message', 'Your Short URL: <a :href="' . url($short_url) . '">'. url($short_url) . '</a>');
    }

    // FUNCTION TO SHOW THE USER THE SHORTENED URL WE HAVE CREATED
    // public function show($code)
    // {
    //     $shortUrl = ShortUrl::where('short_url', $code)->firstOrFail();
    //     $shortUrl->increment('visits');

    //     return redirect($shortUrl->original_url);
    // }

    public function show($code)
    {
       dd($code);
    }

    // public function show($shortUrlKey)
    // {
    //     $shortUrl = ShortUrl::where('short_url', $shortUrlKey)->firstOrFail();
    //     $shortUrl->increment('visits');

    //     return redirect($shortUrl->original_url);
    // }
}