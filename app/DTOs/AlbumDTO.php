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

    public static function toApiResponse($albums)
    {
        if (is_array($albums)) {
            $albums = collect($albums);
        }

        /** @var $albums Collection */
        return $albums->reduce(function ($acc, Album $album) {
            $acc[] = self::singleAlbumToApiResponse($album);
            return $acc;
        }, []);
    }

    private static function singleAlbumToApiResponse(Album $album)
    {
        $albumJson = [
            'id' => $album->id,
            'name' => $album->name,
            'popularity' => $album->popularity,
            'label' => $album->label,
            'release_date' => $album->release_date,
            'spotify_id' => $album->spotify_id,
            'spotify_image_small' => $album->spotify_image_small,
            'spotify_image_medium' => $album->spotify_image_medium,
            'spotify_image_large' => $album->spotify_image_large,
        ];

        if ($album->relationLoaded('tracks')) {
            $albumJson['tracks'] = TrackDTO::toApiResponse($album->tracks);
        }
        if ($album->relationLoaded('artists')) {
            $albumJson['artists'] = ArtistDTO::toApiResponse($album->artists);
        }

        return $album;
    }
}
