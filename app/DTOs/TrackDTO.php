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
            'album' => AlbumDTO::singleAlbumToApiResponse($track->album),
            'artists' => ArtistDTO::toApiResponse($track->artists),
            'audio_features' => AudioFeatureDTO::singleAudioFeatureToApiResponse($track->audioFeatures),
            'spotify_id' => $track->spotify_id,
            'provider' => $track->provider,
            'spotify_track_number' => $track->spotify_track_number,
            'type' => 'track',
        ];
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
