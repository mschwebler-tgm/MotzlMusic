<?php

namespace App\Components\Spotify\Import\Importers;

use App\Components\Spotify\Import\PlaylistImportService;
use App\Components\Spotify\Import\TrackImportService;
use App\Components\Spotify\Models\Playlist;
use App\Components\Spotify\SpotifyDao;
use App\Service\Spotify\SpotifyApiService;

class SpotifyPlaylistImporter implements SpotifyImporter
{
    private $apiService;
    private $trackImportService;
    private $spotifyDao;

    public function __construct(SpotifyApiService $apiService, TrackImportService $trackImportService, SpotifyDao $spotifyDao)
    {
        $this->apiService = $apiService;
        $this->trackImportService = $trackImportService;
        $this->spotifyDao = $spotifyDao;
    }

    public function import($importPlaylistIds)
    {
        if (count($importPlaylistIds) === 0) {
            return;
        }

        $user = apiUser();
        $spotifyPlaylists = $this->getPlaylists($importPlaylistIds);
        /** @var Playlist $spotifyPlaylist */
        foreach ($spotifyPlaylists as $spotifyPlaylist) {
            $playlist = $this->spotifyDao->storePlaylist($spotifyPlaylist, $user->id);
            $playlistTracks = $this->trackImportService->saveTracksForCurrentUser($spotifyPlaylist->tracks);
            $playlist->tracks()->sync($playlistTracks->pluck('id'));
        }
    }

    private function getPlaylists($spotifyPlaylistIds)
    {
        $playlists = collect();
        foreach ($spotifyPlaylistIds as $id) {
            $playlistResponse = $this->apiService->getPlaylist($id);
            $playlists->push(new Playlist($playlistResponse));
        }
        return $playlists;
    }
}
