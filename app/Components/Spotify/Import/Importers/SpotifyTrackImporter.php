<?php

namespace App\Components\Spotify\Import\Importers;

use App\Components\Spotify\SpotifyDTO;

class SpotifyTrackImporter extends SpotifyImporter
{
    /**
     * @param $importSavedTracks boolean
     */
    public function import($importSavedTracks)
    {
        if (!$importSavedTracks) {
            return;
        }

        $tracks = $this->getAllSavedTracks();
        $this->trackImportService->saveTracksForUser($tracks, $this->user);
    }

    private function getAllSavedTracks()
    {
        $itemsPerPage = 20;
        $offset = 0;
        $tracks = [];
        do {
            $response = $this->spotifyApiService->getMySavedTracks(['limit' => $itemsPerPage, 'offset' => $offset]);
            $tracks = array_merge($response->items, $tracks);
            $offset += $itemsPerPage;
        } while (count($tracks) < $response->total);

        return SpotifyDTO::trackModelsFromResponse($tracks);
    }
}
