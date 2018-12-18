<?php

namespace App\Http\Controllers;

use App\Service\Spotify\SpotifyApiService;

class TrackController extends Controller
{
    public function getAudioAnalysis($spotifyId, SpotifyApiService $apiService)
    {
        return (array) $apiService->getAudioAnalysis($spotifyId);
    }
}
