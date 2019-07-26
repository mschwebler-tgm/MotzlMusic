<?php

namespace App\DTOs;

use App\Playlist;
use Illuminate\Support\Collection;

class PlaylistDTO
{
    public static function toApiResponse(Collection $playlists)
    {
        return $playlists->reduce(function ($acc, Playlist $playlist) {
            $acc[] = self::singlePlaylistToApiResponse($playlist);
            return $acc;
        }, []);
    }

    public static function singlePlaylistToApiResponse(Playlist $playlist)
    {
        return [
            'type' => 'playlist',
            'id' => $playlist->id,
            'name' => $playlist->name,
            'is_public' => $playlist->is_public,
            'description' => $playlist->description,
            'spotify_id' => $playlist->spotify_id,
            'spotify_image_small' => $playlist->spotify_image_small,
            'spotify_image_medium' => $playlist->spotify_image_medium,
            'spotify_image_large' => $playlist->spotify_image_large,
            'audio_features' => $playlist->audio_features ?? null,
        ];
    }
}
