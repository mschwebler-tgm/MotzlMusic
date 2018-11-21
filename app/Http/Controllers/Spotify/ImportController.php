<?php

namespace App\Http\Controllers\Spotify;

use App\Components\Spotify\Import\PlaylistTransformer;
use App\Service\Spotify\SpotifyApiService;

class ImportController
{
    public function playlists(SpotifyApiService $apiService, PlaylistTransformer $playlistTransformer)
    {
        $playlists = $apiService->getAllMyPlaylists();
        return $playlistTransformer->transform($playlists);
    }
}