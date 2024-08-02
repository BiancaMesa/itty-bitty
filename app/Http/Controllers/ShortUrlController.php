<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortRequest;
use App\Models\ShortUrl;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ShortUrlController extends Controller
{

    /* API ROUTES: "they don't return anything", they perform a task (show, destroy, get) */

    public function show($shortUrlKey)
    {
        $shortUrl = ShortUrl::where('short_url_key', $shortUrlKey)->firstOrFail();

        $shortUrl->increment('clicks');

        return redirect()->to($shortUrl->original_url);
    }


    public function destroy($id)
    {
        $shortUrl = ShortUrl::findOrFail($id);

        if ($shortUrl->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $shortUrl->delete();

        return response()->noContent();
    }

    public function destroyAll()
    {
        $user = auth()->user();
        ShortUrl::where('user_id', $user->id)->delete();

        return response()->noContent();
    }

    public function getShortUrls()
    {
        $user = auth()->user();
        $shortUrls = ShortUrl::where('user_id', $user->id)->get();

        return response()->json($shortUrls);
    }


    /* API ROUTE BUT RETURNS A VIEW */

    public function short(ShortRequest $request)
    {
        $data = $request->validated();

        $shortUrlKey = $this->genereteShortUrlKey();
        $fullShortenedUrl = url('/' . $shortUrlKey);

        $shortUrl = ShortUrl::create([
            'user_id' => auth()->id(),
            'title' => data_get($data, 'title', 'No title'),// $data['title'],
            'original_url' => data_get($data, 'original_url'),
            'short_url_key' => $shortUrlKey,
            'full_shortened_url' => $fullShortenedUrl,
        ]);

        return Inertia::render('Dashboard', [
            'shortenedUrl' => $fullShortenedUrl,
            'shortUrlId' => $shortUrl->id,
        ]);
    }

    // We create a private function to generate a short URL key 
    // and check if there is already a short URL key in the DB 
    // with that same combination. 
    private function genereteShortUrlKey()
    {
        //1. Generate random combination 
        $shortUrlKey = Str::random(6);

        //2. Check if that combination already exists in the DB 
        //3. If so, we generate another random key but calling this function again
        if (ShortUrl::where('short_url_key', $shortUrlKey)->exists()) {
            $shortUrlKey = $this->genereteShortUrlKey();
        }

        //4. If it doesn't, we return the key
        return $shortUrlKey;
    }


    /* VIEW ROUTES */

    public function manageUrls()
    {
        $user = auth()->user();
        // $shortUrls = ShortUrl::where('user_id', $user->id)->get();
        $shortUrls = ShortUrl::where('user_id', $user->id)->paginate(10);
        return Inertia::render('ManageUrls', [
            'shortUrls' => $shortUrls,
        ]);
    }

    public function analytics()
    {
        $user = auth()->user();
        // $shortUrls = ShortUrl::where('user_id', $user->id)->get(['title', 'original_url', 'full_shortened_url', 'clicks']);
        $shortUrls = ShortUrl::where('user_id', $user->id)->paginate(10);

        return Inertia::render('Analytics', [
            'shortUrls' => $shortUrls,
        ]);
    }

    public function index()
    {
        $user = auth()->user();
        $shortUrls = ShortUrl::where('user_id', $user->id)->get();

        $latestFullShortenedUrl = $user->getLastFullShortenedUrl();

        return Inertia::render('Dashboard', [
            'shortUrls' => $shortUrls,
            'latestFullShortenedUrl' => $latestFullShortenedUrl,
        ]);
    }
}
