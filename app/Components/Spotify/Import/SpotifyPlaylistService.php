<?php

namespace App\Components\Spotify\Import;

use App\Components\Spotify\Api\SpotifyApi;

class SpotifyPlaylistService extends AbstractSpotifyDataService
{
    public function __construct(SpotifyApi $spotifyApi, PlaylistTransformer $playlistTransformer)
    {
        $this->spotifyApi = $spotifyApi;
        $this->transformer = $playlistTransformer;
    }

    protected function getApiServiceMethod()
    {
        return 'getMyPlaylists';
    }
}
