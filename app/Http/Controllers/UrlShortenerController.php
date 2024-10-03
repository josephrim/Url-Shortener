<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class UrlShortenerController extends Controller
{
    public function encode(Request $request)
    {
        // Validate with JSON response
        $request->validate([
            'url' => 'required|url',
        ]);

        $originalUrl = $request->url;
        $shortCode = Str::random(6);
        $shortUrl = 'http://short.est/' . $shortCode;

        // Store mapping in cache for 1 hour
        Cache::put($shortCode, $originalUrl, now()->addHours(1));

        return response()->json(['short_url' => $shortUrl]);
    }

    public function decode(Request $request)
    {
        // Validate with JSON response
        $request->validate([
            'short_url' => 'required|url',
        ]);

        $shortCode = basename($request->short_url);
        $originalUrl = Cache::get($shortCode);

        if (!$originalUrl) {
            return response()->json(['error' => 'URL not found'], 404);
        }

        return response()->json(['original_url' => $originalUrl]);
    }
}
