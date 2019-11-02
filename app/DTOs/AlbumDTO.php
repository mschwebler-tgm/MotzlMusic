<?php

namespace App\DTOs;

use App\Album;
use App\Components\Spotify\Models\Album as SpotifyAlbum;
use Illuminate\Support\Collection;

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
