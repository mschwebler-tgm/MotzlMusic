<?php

namespace App\DTOs;

use App\Components\Spotify\Models\Artist as SpotifyArtist;

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
}
