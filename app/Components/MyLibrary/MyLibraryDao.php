<?php

namespace App\Components\MyLibrary;

use App\Daos\AudioFeatureDao;
use App\Playlist;
use App\Track;
use App\User;

class MyLibraryDao
{
    /** @var User */
    private $user;
    private $audioFeatureDao;

    public function __construct(AudioFeatureDao $playlistDao)
    {
        $this->user = apiUser();
        $this->audioFeatureDao = $playlistDao;
    }

    public function getAllPlaylistsExcept(array $except = [])
    {
        $playlists = Playlist::where('user_id', $this->user->id)
            ->orderBy('updated_at', 'desc')
            ->whereNotIn('id', $except)
            ->get();

        return $this->audioFeatureDao->addAverageAudioFeaturesTo($playlists);
    }

    public function getRecentPlaylists($amount)
    {
        $playlists = Playlist::where('user_id', $this->user->id)
            ->orderBy('created_at', 'desc')
            ->limit($amount)
            ->get();

        return $this->audioFeatureDao->addAverageAudioFeaturesTo($playlists);
    }

    public function getSpotifyPlaylists()
    {
        $playlists = Playlist::where('user_id', $this->user->id)
            ->orderBy('created_at', 'desc')
            ->whereNotNull('spotify_id')
            ->get();

        return $this->audioFeatureDao->addAverageAudioFeaturesTo($playlists);
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
