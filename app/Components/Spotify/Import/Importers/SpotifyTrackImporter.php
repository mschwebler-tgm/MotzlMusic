<?php

namespace App\Components\Spotify\Import\Importers;

use App\Components\Spotify\Import\TrackImporterDao;
use App\Components\Spotify\Models\Track;
use App\Service\Spotify\SpotifyApiService;

class SpotifyTrackImporter implements SpotifyImporter
{
    private $apiService;
    private $trackImporterDao;

    public function __construct(SpotifyApiService $apiService, TrackImporterDao $trackImporterDao)
    {
        $this->apiService = $apiService;
        $this->trackImporterDao = $trackImporterDao;
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
        $this->trackImporterDao->saveTracksForCurrentUser($tracks);
        // TODO dispatch refinement job to complete tracks data
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
