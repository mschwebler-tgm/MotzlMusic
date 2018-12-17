<?php

namespace App\DTOs;

use App\Components\Spotify\Models\Album as SpotifyAlbum;

class AlbumDTO implements SpotifyDTO
{
    public static function spotifyToModels($albumsResponse)
    {
        $albums = collect();
        foreach ($albumsResponse as $singleAlbumResponse) {
            $albums->push(self::spotifyToModel($singleAlbumResponse));
        }
        return $albums;
    }

    public static function spotifyToModel($singleAlbumResponse)
    {
        return new SpotifyAlbum($singleAlbumResponse);
    }
}
