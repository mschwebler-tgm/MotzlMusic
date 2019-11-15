<?php

namespace App\Components\MyLibrary;

use App\Playlist;
use App\Track;
use App\User;

class MyLibraryDao
{
    /** @var User */
    private $user;

    public function __construct()
    {
        $this->user = apiUser();
    }

    public function getAllPlaylistsExcept(array $except = [])
    {
        return Playlist::where('user_id', $this->user->id)
            ->orderBy('updated_at', 'desc')
            ->whereNotIn('id', $except)
            ->get();
    }

    public function getRecentPlaylists($amount)
    {
        return Playlist::where('user_id', $this->user->id)
            ->orderBy('created_at', 'desc')
            ->limit($amount)
            ->get();
    }

    public function getSpotifyPlaylists()
    {
        return Playlist::where('user_id', $this->user->id)
            ->orderBy('created_at', 'desc')
            ->whereNotNull('spotify_id')
            ->get();
    }

    public function getAllTracks()
    {
        return Track::ofCurrentUser()
            ->with('artists', 'album', 'audioFeatures')
            ->orderBy('name', 'asc')->get();
    }

    public function addTrack($id)
    {
        apiUser()->tracks()->attach($id);
    }

    public function removeTrack($id)
    {
        apiUser()->tracks()->detach([$id]);
    }
}
