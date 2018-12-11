<?php

namespace App\Components\Spotify\Import\Importers;

use App\Components\Spotify\Import\PlaylistImportService;
use App\Components\Spotify\Import\TrackImportService;
use App\Components\Spotify\Models\Playlist;
use App\Service\Spotify\SpotifyApiService;

class SpotifyPlaylistImporter implements SpotifyImporter
{
    private $apiService;
    private $trackImportService;
    private $playlistImportService;

    public function __construct(SpotifyApiService $apiService, TrackImportService $trackImportService, PlaylistImportService $playlistImportService)
    {
        $this->apiService = $apiService;
        $this->trackImportService = $trackImportService;
        $this->playlistImportService = $playlistImportService;
    }

    public function import($importPlaylistIds)
    {
        if (count($importPlaylistIds) === 0) {
            return;
        }

        $playlists = $this->getPlaylists($importPlaylistIds);
        // TODO save playlists and tracks
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
