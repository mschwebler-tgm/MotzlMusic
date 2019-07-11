<?php

namespace App\Components\MyLibrary;

use App\Daos\PlaylistDao;
use App\Playlist;
use App\Track;
use App\User;

class MyLibraryDao
{
    /** @var User */
    private $user;
    private $playlistDao;

    public function __construct(PlaylistDao $playlistDao)
    {
        $this->user = apiUser();
        $this->playlistDao = $playlistDao;
    }

    public function getAllPlaylistsExcept(array $except = [])
    {
        $playlists = Playlist::where('user_id', $this->user->id)
            ->orderBy('updated_at', 'desc')
            ->whereNotIn('id', $except)
            ->get();

        return $this->playlistDao->addAudioFeatures($playlists);
    }

    public function getRecentPlaylists($amount)
    {
        $playlists = Playlist::where('user_id', $this->user->id)
            ->orderBy('created_at', 'desc')
            ->limit($amount)
            ->get();

        return $this->playlistDao->addAudioFeatures($playlists);
    }

    public function getSpotifyPlaylists()
    {
        $playlists = Playlist::where('user_id', $this->user->id)
            ->orderBy('created_at', 'desc')
            ->whereNotNull('spotify_id')
            ->get();

        return $this->playlistDao->addAudioFeatures($playlists);
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
