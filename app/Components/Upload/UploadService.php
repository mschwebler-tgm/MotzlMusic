<?php

namespace App\Components\Upload;

use App\Components\Spotify\Import\TrackImportService;
use App\Components\Spotify\Refinement\RefinementQueue;
use App\Components\Upload\Matcher\SpotifyMatcher;
use App\Http\Controllers\FileController;
use App\Track;
use App\User;
use Illuminate\Support\Str;

class UploadService
{
    private $spotifyMatcher;
    private $trackImportService;

    public function __construct(SpotifyMatcher $spotifyMatcher)
    {
        $this->spotifyMatcher = $spotifyMatcher;
        $this->trackImportService = new TrackImportService(
            app(UploadDao::class),
            app(RefinementQueue::class)
        );
    }

    public function storeFromRequest(SingleUploadRequest $request, User $user)
    {
        $trackName = $request->getFileName();
        $spotifyTrack = $this->spotifyMatcher->getEstimatedSpotifyMatch($trackName);
        if ($spotifyTrack) {
            $eventDispatcher = Track::getEventDispatcher();
            Track::unsetEventDispatcher();
            // TODO refactor: move to dao
            $track = $this->trackImportService->storeTrackForUser($spotifyTrack, $user);
            $file = $request->getFile();
            $filePath = $file->storeAs(FileController::PATH_TRACK_FILE, Str::random(40) . '.mp3');
            $track->local_path = $filePath;
            $track->save();
            Track::setEventDispatcher($eventDispatcher);
        }
    }
}
