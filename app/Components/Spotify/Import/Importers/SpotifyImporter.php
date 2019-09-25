<?php

namespace App\Components\Spotify\Import\Importers;

use App\Components\Spotify\Api\UserBoundSpotifyApi;
use App\Components\Spotify\Import\TrackImportService;
use App\Components\Spotify\Api\SpotifyApi;
use App\User;

abstract class SpotifyImporter
{
    protected $user;
    /** @var SpotifyApi */
    protected $userBoundSpotifyApi;
    /** @var TrackImportService */
    protected $trackImportService;

    public abstract function import($options);

    public function setUser(User $user) {
        $this->user = $user;
    }

    public function setUserBoundSpotifyApi(UserBoundSpotifyApi $userBoundSpotifyApi) {
        $this->userBoundSpotifyApi = $userBoundSpotifyApi;
    }

    public function setTrackImportService(TrackImportService $trackImportService)
    {
        $this->trackImportService = $trackImportService;
    }
}
