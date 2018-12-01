<?php

namespace App\Components\Spotify\Models\Traits;

use App\Components\Spotify\Models\Track;

trait HasTracks
{
    protected function setTracksFromApiResponse($apiResponseTracks)
    {
        if ($apiResponseTracks === null) {
            return;
        }

        $tracks = collect();
        foreach ($apiResponseTracks as $apiResponseTrack) {
            $tracks->push(new Track($apiResponseTrack));
        }
        $this->tracks = $tracks;
    }
}
