<?php

namespace App\Components\Spotify\Import\Importers;

use App\Components\Spotify\Import\TrackImportService;
use App\Components\Spotify\Models\Track;
use App\Service\Spotify\SpotifyApiService;

class SpotifyTrackImporter implements SpotifyImporter
{
    private $apiService;
    private $trackImportService;

    public function __construct(SpotifyApiService $apiService, TrackImportService $trackImportService)
    {
        $this->apiService = $apiService;
        $this->trackImportService = $trackImportService;
    }

    /**
     * @param $importSavedTracks boolean
     */
    public function import($importSavedTracks)
    {
        if (!$importSavedTracks) {
            return;
        }

        $tracks = $this->getAllSavedTracks();
        $this->trackImportService->saveTracksForCurrentUser($tracks);
    }

    private function getAllSavedTracks()
    {
        $itemsPerPage = 20;
        $offset = 0;
        $tracks = [];
        do {
            $response = $this->apiService->getMySavedTracks(['limit' => $itemsPerPage, 'offset' => $offset]);
            $tracks = array_merge($response->items, $tracks);
            $offset += $itemsPerPage;
        } while (count($tracks) < $response->total);

        return collect($tracks)->map(function($item) {
            return (new Track($item->track));
        });
    }
}
