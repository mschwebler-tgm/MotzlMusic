<?php

namespace App\Components\Spotify\Import;

use App\Service\Spotify\SpotifyApiService;

class SpotifyPlaylistService extends AbstractSpotifyDataService
{
    public function __construct(SpotifyApiService $apiService, PlaylistTransformer $playlistTransformer)
    {
        $this->apiService = $apiService;
        $this->transformer = $playlistTransformer;
    }

    protected function getApiServiceMethod()
    {
        return 'getMyPlaylists';
    }
}
