<?php

namespace App\Components\Spotify\Import;

use App\Components\Spotify\Api\UserBoundSpotifyApi;

class SpotifyAlbumService extends AbstractSpotifyDataService
{
    public function __construct(UserBoundSpotifyApi $userBoundSpotifyApi, AlbumTransformer $trackTransformer)
    {
        $this->userBoundSpotifyApi = $userBoundSpotifyApi;
        $this->transformer = $trackTransformer;
    }

    protected function getApiServiceMethod()
    {
        return 'getMySavedAlbums';
    }
}
