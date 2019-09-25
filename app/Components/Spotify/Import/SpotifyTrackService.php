<?php

namespace App\Components\Spotify\Import;

use App\Components\Spotify\Api\UserBoundSpotifyApi;

class SpotifyTrackService extends AbstractSpotifyDataService
{
    public function __construct(UserBoundSpotifyApi $userBoundSpotifyApi, TrackTransformer $trackTransformer)
    {
        $this->userBoundSpotifyApi = $userBoundSpotifyApi;
        $this->transformer = $trackTransformer;
    }

    protected function getApiServiceMethod()
    {
        return 'getMySavedTracks';
    }
}
