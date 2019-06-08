<?php

namespace App\Components\Spotify\Import;

use App\Service\Spotify\SpotifyApiService;

class SpotifyTrackService extends AbstractSpotifyDataService
{
    public function __construct(SpotifyApiService $apiService, TrackTransformer $trackTransformer)
    {
        $this->apiService = $apiService;
        $this->transformer = $trackTransformer;
    }

    protected function getApiServiceMethod()
    {
        return 'getMySavedTracks';
    }
}
