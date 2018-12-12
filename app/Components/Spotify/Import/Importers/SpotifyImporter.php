<?php

namespace App\Components\Spotify\Import\Importers;

use App\Components\Spotify\Import\TrackImportService;
use App\Service\Spotify\SpotifyApiService;
use App\User;

abstract class SpotifyImporter
{
    protected $user;
    /** @var SpotifyApiService */
    protected $spotifyApiService;
    /** @var TrackImportService */
    protected $trackImportService;

    public abstract function import($options);

    public function setUser(User $user) {
        $this->user = $user;
    }

    public function setSpotifyApiService(SpotifyApiService $spotifyApiService) {
        $this->spotifyApiService = $spotifyApiService;
    }

    public function setTrackImportService(TrackImportService $trackImportService)
    {
        $this->trackImportService = $trackImportService;
    }
}
