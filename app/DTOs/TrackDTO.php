<?php

namespace App\DTOs;

use App\Components\Spotify\Models\Track as SpotifyTrack;

class TrackDTO implements SpotifyDTO
{
    public static function spotifyToModels($trackResponse) {
        $tracks = collect();
        foreach ($trackResponse as $singleTrackResponse) {
            $tracks->push(self::spotifyToModel($singleTrackResponse));
        }
        return $tracks;
    }

    public static function spotifyToModel($trackResponse) {
        return new SpotifyTrack($trackResponse->track);
    }
}
