<?php

namespace App\Components\Spotify\Import\Importers;

use App\Components\Spotify\Import\PlaylistImportService;
use App\Components\Spotify\Models\Playlist;
use App\Components\Spotify\SpotifyDao;

class SpotifyPlaylistImporter extends SpotifyImporter
{
    private $spotifyDao;

    public function __construct(SpotifyDao $spotifyDao)
    {
        $this->spotifyDao = $spotifyDao;
    }

    public function import($importPlaylistIds)
    {
        if (count($importPlaylistIds) === 0) {
            return;
        }

        $spotifyPlaylists = $this->getPlaylists($importPlaylistIds);
        /** @var Playlist $spotifyPlaylist */
        foreach ($spotifyPlaylists as $spotifyPlaylist) {
            $playlist = $this->spotifyDao->storePlaylist($spotifyPlaylist, $this->user->id);
            $playlistTracks = $this->trackImportService->saveTracksForUser($spotifyPlaylist->tracks, $this->user);
            $playlist->tracks()->sync($playlistTracks->pluck('id'));
        }
    }

    private function getPlaylists($spotifyPlaylistIds)
    {
        $playlists = collect();
        foreach ($spotifyPlaylistIds as $id) {
            $playlistResponse = $this->spotifyApiService->getPlaylist($id);
            $playlists->push(new Playlist($playlistResponse));
        }
        return $playlists;
    }
}
