<?php

namespace App\DTOs;

use App\Artist;
use App\Components\Spotify\Models\Artist as SpotifyArtist;
use Illuminate\Database\Eloquent\Collection;

class ArtistDTO implements SpotifyDTO
{
    public static function spotifyToModels($artistsResponse)
    {
        $artists = collect();
        foreach ($artistsResponse as $singleArtistResponse) {
            $artists->push(self::spotifyToModel($singleArtistResponse));
        }
        return $artists;
    }

    public static function spotifyToModel($artistResponse)
    {
        return new SpotifyArtist($artistResponse);
    }

    public static function toApiResponse(Collection $artists)
    {
        return $artists->reduce(function ($acc, Artist $artists) {
            $acc[] = self::singleArtistToApiResponse($artists);
            return $acc;
        }, []);
    }

    public static function singleArtistToApiResponse(Artist $artists)
    {
        return [
            'id' => $artists->id,
            'name' => $artists->name,
            'popularity' => $artists->popularity,
            'spotify_id' => $artists->spotify_id,
            'spotify_image_small' => $artists->spotify_image_small,
            'spotify_image_medium' => $artists->spotify_image_medium,
            'spotify_image_large' => $artists->spotify_image_large,
        ];
    }
}
