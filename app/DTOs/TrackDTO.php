<?php

namespace App\DTOs;

use App\Components\Spotify\Models\Track as SpotifyTrack;
use App\Track;
use Illuminate\Support\Collection;

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

    public static function toApiResponse($tracks)
    {
        if ($tracks instanceof Track) {
            return self::singleTrackToApiResponse($tracks);
        }

        /** @var $tracks Collection */
        return $tracks->reduce(function ($acc, Track $track) {
            $acc[] = self::singleTrackToApiResponse($track);
            return $acc;
        }, []);
    }

    public static function singleTrackToApiResponse(Track $track)
    {
        return [
            'id' => $track->id,
            'name' => $track->name,
            'popularity' => $track->popularity,
            'duration' => $track->duration,
            'duration_formatted' => formatDuration($track->duration),
            'album' => $track->album,
            'artist' => $track->artists->first(),
            'spotify_id' => $track->spotify_id,
            'is_spotify' => (bool) $track->spotify_id,
            'spotify_track_number' => $track->spotify_track_number,
        ];
    }
}
