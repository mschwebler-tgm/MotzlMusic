<?php

namespace App\Components\Spotify\Import;

use App\Components\Spotify\Api\UserBoundSpotifyApi;

class SpotifyPlaylistService extends AbstractSpotifyDataService
{
    public function __construct(UserBoundSpotifyApi $userBoundSpotifyApi, PlaylistTransformer $playlistTransformer)
    {
        $this->userBoundSpotifyApi = $userBoundSpotifyApi;
        $this->transformer = $playlistTransformer;
    }

    protected function getApiServiceMethod()
    {
        return 'getMyPlaylists';
    }
}
