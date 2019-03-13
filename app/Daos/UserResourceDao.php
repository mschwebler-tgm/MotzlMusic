<?php

namespace App\Daos;

use App\Playlist;
use App\Service\UserResourceGuard;

class UserResourceDao
{
    private $currentUser;

    public function __construct()
    {
        $this->currentUser = apiUser();
    }

    public function getPlaylist($id)
    {
        $playlist = Playlist::with('user')->find($id);

        return UserResourceGuard::getResource($playlist);
    }

    public function getPlaylistTracks($playlistId)
    {
        $playlist = Playlist::with('user', 'tracks.artists', 'tracks.album')->find($playlistId);

        return UserResourceGuard::getResource($playlist)->tracks;
    }
}
