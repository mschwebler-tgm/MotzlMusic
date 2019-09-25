<?php

namespace App\Components\Spotify\Import;

use App\Components\Spotify\Api\SpotifyApi;

class SpotifyTrackService extends AbstractSpotifyDataService
{
    public function __construct(SpotifyApi $spotifyApi, TrackTransformer $trackTransformer)
    {
        $this->spotifyApi = $spotifyApi;
        $this->transformer = $trackTransformer;
    }

    protected function getApiServiceMethod()
    {
        return 'getMySavedTracks';
    }
}
