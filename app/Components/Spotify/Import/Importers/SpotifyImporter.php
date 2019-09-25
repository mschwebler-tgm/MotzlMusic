<?php

namespace App\Components\Spotify\Import\Importers;

use App\Components\Spotify\Import\TrackImportService;
use App\Components\Spotify\Api\SpotifyApi;
use App\User;

abstract class SpotifyImporter
{
    protected $user;
    /** @var SpotifyApi */
    protected $spotifyApi;
    /** @var TrackImportService */
    protected $trackImportService;

    public abstract function import($options);

    public function setUser(User $user) {
        $this->user = $user;
    }

    public function setSpotifyApi(SpotifyApi $spotifyApi) {
        $this->spotifyApi = $spotifyApi;
    }

    public function setTrackImportService(TrackImportService $trackImportService)
    {
        $this->trackImportService = $trackImportService;
    }
}
