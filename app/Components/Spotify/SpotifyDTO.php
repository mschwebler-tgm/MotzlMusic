<?php

namespace App\Components\Spotify;

use App\Components\Spotify\Models\Album as SpotifyAlbum;
use App\Components\Spotify\Models\AudioFeatures as SpotifyAudioFeatures;
use App\Components\Spotify\Models\Artist as SpotifyArtist;
use App\Components\Spotify\Models\Track as SpotifyTrack;

class SpotifyDTO
{
    /*
    |--------------------------------------------------------------------------
    | Album Models
    |--------------------------------------------------------------------------
    */
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

    /*
    |--------------------------------------------------------------------------
    | Artist Models
    |--------------------------------------------------------------------------
    */
    public static function artistModelsFromResponse($artistsResponse)
    {
        $artists = collect();
        foreach ($artistsResponse as $singleArtistResponse) {
            $artists->push(self::artistModelFromResponse($singleArtistResponse));
        }
        return $artists;
    }

    public static function artistModelFromResponse($artistResponse)
    {
        return new SpotifyArtist($artistResponse);
    }

    /*
    |--------------------------------------------------------------------------
    | Track Models
    |--------------------------------------------------------------------------
    */
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


    /*
    |--------------------------------------------------------------------------
    | Audio Feature Models
    |--------------------------------------------------------------------------
    */
    public static function audioFeatureModelsFromResponse($audioFeaturesResponse)
    {
        $audioFeatures = collect();
        foreach ($audioFeaturesResponse as $singleAudioFeatureResponse) {
            $audioFeatures->push(self::audioFeatureModelFromResponse($singleAudioFeatureResponse));
        }
        return $audioFeatures;
    }

    public static function audioFeatureModelFromResponse($audioFeatureResponse)
    {
        return new SpotifyAudioFeatures($audioFeatureResponse);
    }
}
