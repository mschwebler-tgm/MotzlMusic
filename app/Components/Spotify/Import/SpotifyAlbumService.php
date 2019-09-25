<?php

namespace App\Components\Spotify\Import;

use App\Components\Spotify\Api\SpotifyApi;

class SpotifyAlbumService extends AbstractSpotifyDataService
{
    public function __construct(SpotifyApi $spotifyApi, AlbumTransformer $trackTransformer)
    {
        $this->spotifyApi = $spotifyApi;
        $this->transformer = $trackTransformer;
    }

    protected function getApiServiceMethod()
    {
        return 'getMySavedAlbums';
    }
}
