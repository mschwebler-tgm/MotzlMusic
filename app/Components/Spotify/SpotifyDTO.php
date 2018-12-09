<?php

namespace App\Components\Spotify;

use App\Components\Spotify\Models\Album as SpotifyAlbum;
use App\Components\Spotify\Models\Artist as SpotifyArtist;
use App\Components\Spotify\Models\Track as SpotifyTrack;

class SpotifyDTO
{
    public static function albumModelsFromResponse($albumsResponse) {
        $albums = collect();
        foreach ($albumsResponse as $singleAlbumsResponse) {
            $albums->push(self::albumModelFromResponse($singleAlbumsResponse));
        }
        return $albums;
    }

    public static function albumModelFromResponse($albumResponse) {
        return new SpotifyAlbum($albumResponse);
    }

    public static function trackModelsFromResponse($trackResponse) {
        $tracks = collect();
        foreach ($trackResponse as $singleTrackResponse) {
            $tracks->push(self::trackModelFromResponse($singleTrackResponse));
        }
        return $tracks;
    }

    public static function trackModelFromResponse($trackResponse) {
        return new SpotifyTrack($trackResponse->track);
    }

    public static function artistsModelsFromResponse($artistsResponse)
    {
        $artists = collect();
        foreach ($artistsResponse as $singleArtistResponse) {
            $artists->push(self::artistModelsFromResponse($singleArtistResponse));
        }
        return $artists;
    }

    public static function artistModelsFromResponse($artistResponse)
    {
        return new SpotifyArtist($artistResponse);
    }
}
