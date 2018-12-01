<?php

namespace App\Components\Spotify\Import\Importers;

use App\Service\Spotify\SpotifyApiService;

class SpotifyTrackImporter implements SpotifyImporter
{
    private $apiService;

    public function __construct(SpotifyApiService $apiService)
    {
        $this->apiService = $apiService;
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
            return $item->track;
        });
    }
}
