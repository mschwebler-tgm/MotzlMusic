<?php

namespace App\Components\Spotify\DTOs;

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

    /**
     * @param SpotifyTrack $spotifyTrack
     * @param null $albumId
     * @return array
     */
    public static function spotifyModelToDatabaseArray(SpotifyTrack $spotifyTrack, $albumId = null) {
        return [
            'name' => $spotifyTrack->name,
            'spotify_id' => $spotifyTrack->id,
            'isrc' => $spotifyTrack->externalIds->isrc,
            'duration' => $spotifyTrack->duration,
            'popularity' => $spotifyTrack->popularity,
            'spotify_href' => $spotifyTrack->href,
            'spotify_uri' => $spotifyTrack->uri,
            'spotify_track_number' => $spotifyTrack->trackNumber,
            'album_id' => $albumId,
        ];
    }
}
