<?php

namespace App\Components\Spotify\Import\Importers;

use App\Components\Spotify\Import\TrackImportService;
use App\Components\Spotify\SpotifyDTO;
use App\Service\Spotify\SpotifyApiService;
use Illuminate\Support\Collection;

class SpotifyAlbumImporter implements SpotifyImporter
{
    private $apiService;
    private $trackImportService;

    public function __construct(SpotifyApiService $apiService, TrackImportService $trackImportService)
    {
        $this->apiService = $apiService;
        $this->trackImportService = $trackImportService;
    }

    public function import($spotifyAlbumIds)
    {
        if (count($spotifyAlbumIds) === 0) {
            return;
        }

        $spotifyAlbumsResponse = $this->apiService->getAlbums($spotifyAlbumIds);
        $spotifyAlbums = SpotifyDTO::albumModelsFromResponse($spotifyAlbumsResponse->albums);
        $spotifyAlbums = $this->setAlbumForAlbumTracks($spotifyAlbums);
        $spotifyTracks = $spotifyAlbums->pluck('tracks')->flatten();
        $this->trackImportService->saveTracksForCurrentUser($spotifyTracks);
    }

    /**
     * @param $spotifyAlbums Collection
     * @return Collection
     */
    private function setAlbumForAlbumTracks(Collection $spotifyAlbums)
    {
        $spotifyAlbums = $spotifyAlbums->map(function ($album) {
            $album->tracks = $album->tracks->map(function ($track) use ($album) {
                $album->tracks = null;
                $track->album = $album;
                return $track;
            });
            return $album;
        });
        return $spotifyAlbums;
    }
}
