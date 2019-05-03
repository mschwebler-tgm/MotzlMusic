<?php

namespace App\Components\Spotify\Import;

use App\Service\Spotify\SpotifyApiService;

class SpotifyAlbumService extends AbstractSpotifyDataService
{
    public function __construct(SpotifyApiService $apiService, AlbumTransformer $trackTransformer)
    {
        $this->apiService = $apiService;
        $this->transformer = $trackTransformer;
    }

    protected function getApiServiceMethod()
    {
        return 'getMySavedAlbums';
    }
}
