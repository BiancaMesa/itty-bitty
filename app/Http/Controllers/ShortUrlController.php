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
        $user = auth()->user();
        $shortUrls = ShortUrl::where('user_id', $user->id)->get();

        $latestFullShortenedUrl = $user->getLastFullShortenedUrl();

        return Inertia::render('Dashboard', [
            'shortUrls' => $shortUrls, 
            'latestFullShortenedUrl' => $latestFullShortenedUrl, 
            'shortenedUrl' => session('shortenedUrl'),
        ]);
    }

    public function short(ShortRequest $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'original_url' => 'required|url',
        ]);

        $shortUrlKey = Str::random(6);
        $fullShortenedUrl = url('/' . $shortUrlKey);

        $shortUrl = ShortUrl::create([
            'user_id' => auth()->id(), 
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
