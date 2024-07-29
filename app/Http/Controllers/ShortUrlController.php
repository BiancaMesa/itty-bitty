<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortRequest;
use App\Models\ShortUrl;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ShortUrlController extends Controller
{

    /**
     * API ROUTES
    */

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
        // $user = auth()->user();
        // // $shortUrl = ShortUrl::findOrFail();
        // $shortUrls = ShortUrl::where('user_id', $user->id)->get();

        // if ($shortUrl->user_id !== auth()->id()) {
        //     return response()->json(['message' => 'Unauthorized'], 403);
        // }

        // $shortUrls->delete();

        $user = auth()->user();
        $shortUrls = ShortUrl::where('user_id', $user->id)->delete();

        return response()->noContent();
    }


    /**
     * THIS ROUTE IS API BUT RETURNS VIEW
     */

    public function short(ShortRequest $request)
    {
        //doble validation
        // $request->validate([
        //     'title' => 'required|string|max:100',
        //     'original_url' => 'required|url',
        // ]);
        $data = $request->validated();

        //no es unico el url
        //  Generar un metodo que compruebe si ya existe ese url en la base de datos
        // $shortUrlKey = Str::random(6);
        $shortUrlKey = $this->genereteShortUrlKey();
        $fullShortenedUrl = url('/' . $shortUrlKey);

        // $shortUrl = ShortUrl::create([
        //     'user_id' => auth()->id(), 
        //     'title' => $request->title,
        //     'original_url' => $request->original_url,
        //     'short_url_key' => $shortUrlKey,
        //     'full_shortened_url' => $fullShortenedUrl,
        // ]);

        $shortUrl = ShortUrl::create([
            'user_id' => auth()->id(),
            'title' => data_get($data, 'title', 'Sin titulo'),// $data['title'],
            'original_url' => data_get($data, 'original_url'),
            'short_url_key' => $shortUrlKey,
            'full_shortened_url' => $fullShortenedUrl,
        ]);

        return Inertia::render('Dashboard', [
            'shortenedUrl' => $fullShortenedUrl,
            'shortUrlId' => $shortUrl->id,
        ]);
    }

    private function genereteShortUrlKey()
    {
        //1 Generar el random
        $shortUrlKey = Str::random(6);

        //2 Comprobar si existe en la base de datos
        //3 Si existe, generar otro llamandose asi mismo
        if (ShortUrl::where('short_url_key', $shortUrlKey)->exists()) {
            $shortUrlKey = $this->genereteShortUrlKey();
        }

        //4 Si no existe, devolver el key
        return $shortUrlKey;
    }


    /**
     * VIEW ROUTES
    */

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

    public function index()
    {
        $user = auth()->user();
        $shortUrls = ShortUrl::where('user_id', $user->id)->get();

        $latestFullShortenedUrl = $user->getLastFullShortenedUrl();

        return Inertia::render('Dashboard', [
            'shortUrls' => $shortUrls,
            'latestFullShortenedUrl' => $latestFullShortenedUrl,
            'shortenedUrl' => session('shortenedUrl'),//??
        ]);
    }

}
