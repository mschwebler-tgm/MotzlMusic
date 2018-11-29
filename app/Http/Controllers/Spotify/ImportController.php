<?php

namespace App\Http\Controllers\Spotify;

use App\Components\Spotify\Import\AlbumService;
use App\Components\Spotify\Import\PlaylistTransformer;
use App\Components\Spotify\Import\TrackService;
use App\Service\Spotify\SpotifyApiService;

class ImportController
{
    public function playlists(SpotifyApiService $apiService, PlaylistTransformer $playlistTransformer)
    {
        $playlists = $apiService->getAllMyPlaylists();
        return $playlistTransformer->transform($playlists);
    }

    public function tracks(TrackService $trackService)
    {
        return $trackService->paginate();
    }

    public function albums(AlbumService $albumService)
    {
        return $albumService->paginate();
    }
}