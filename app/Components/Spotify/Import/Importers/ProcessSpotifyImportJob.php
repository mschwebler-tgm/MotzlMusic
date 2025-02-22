<?php

namespace App\Components\Spotify\Import\Importers;

use App\Components\Spotify\Api\UserBoundSpotifyApi;
use App\Components\Spotify\Import\TrackImportService;
use App\Exceptions\FailedSpotifyTokenRefreshException;
use App\Components\Spotify\Api\SpotifyApi;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessSpotifyImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var SpotifyImporter $importer */
    private $importer;
    private $importOptions;
    private $user;

    public function __construct(SpotifyImporter $importer, $options, User $user)
    {
        $this->importer = $importer;
        $this->importOptions = $options;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws FailedSpotifyTokenRefreshException
     */
    public function handle()
    {
        /** @var UserBoundSpotifyApi $spotifyApi */
        $spotifyApi = app(UserBoundSpotifyApi::class);
        $spotifyApi->setApiUser($this->user);

        $trackImportService = app(TrackImportService::class);
        $trackImportService->setCurrentUser($this->user);

        $this->importer->setUser($this->user);
        $this->importer->setUserBoundSpotifyApi($spotifyApi);
        $this->importer->setTrackImportService($trackImportService);
        $this->importer->import($this->importOptions);
    }
}
