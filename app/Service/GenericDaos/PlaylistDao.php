<?php

namespace App\Service\GenericDaos;

use App\Playlist;
use Illuminate\Support\Collection;

class PlaylistDao
{
    public function getAllPlaylistsExcept(array $except = []): Collection
    {
        return Playlist::orderBy('updated_at', 'desc')
            ->whereNotIn('id', $except)
            ->get();
    }

    public function getRecentPlaylists($amount): Collection
    {
        return Playlist::orderBy('created_at', 'desc')
            ->limit($amount)
            ->get();
    }

    public function getSpotifyPlaylists(): Collection
    {
        return Playlist::orderBy('created_at', 'desc')
            ->whereNotNull('spotify_id')
            ->get();
    }
}
