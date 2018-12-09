<?php

namespace App\Components\Spotify\Import;

use App\Album;
use App\Components\Spotify\Models\Track as SpotifyTrack;
use App\Components\Spotify\Refinement\Jobs\RefineAlbumsJob;
use App\Components\Spotify\Refinement\Jobs\RefineArtistsJob;
use App\Components\Spotify\Refinement\Jobs\RefineTracksJob;
use App\Track;
use Illuminate\Support\Collection;

class TrackImportService
{
    private $trackImporterDao;
    private $trackRefinementQueue = [];
    private $albumRefinementQueue = [];
    private $artistRefinementQueue = [];

    const MAX_QUEUE_LIMIT = 20;

    public function __construct(TrackImporterDao $trackImporterDao)
    {
        $this->trackImporterDao = $trackImporterDao;
    }

    public function saveTracksForCurrentUser(Collection $spotifyTracks)
    {
        /** @var SpotifyTrack $spotifyTrack */
        foreach ($spotifyTracks as $spotifyTrack) {
            $track = $this->trackImporterDao->storeTrack($spotifyTrack, apiUser());
            $album = $this->trackImporterDao->storeAlbum($spotifyTrack->album);
            $artists = $this->trackImporterDao->storeArtists($spotifyTrack->artists);
            $this->addToRefinementQueue($track, $album, $artists);
        }
        $this->dispatchRefinementJobs(true);
    }

    private function addToRefinementQueue(Track $track, Album $album, Collection $artists)
    {
        $this->trackRefinementQueue = array_unique(array_merge($this->trackRefinementQueue, [$track->spotify_id]));
        $this->albumRefinementQueue = array_unique(array_merge($this->albumRefinementQueue, [$album->spotify_id]));
        $this->artistRefinementQueue = array_unique(array_merge($this->artistRefinementQueue, $artists->pluck('spotify_id')->toArray()));
        $this->dispatchRefinementJobs();
    }

    private function dispatchRefinementJobs($force = false)
    {
        if ($force || count($this->trackRefinementQueue) >= self::MAX_QUEUE_LIMIT) {
            $this->dispatchTrackRefinementJob();
        }
        if ($force || count($this->albumRefinementQueue) >= self::MAX_QUEUE_LIMIT) {
            $this->dispatchAlbumRefinementJob();
        }
        if ($force || count($this->artistRefinementQueue) >= self::MAX_QUEUE_LIMIT) {
            $this->dispatchArtistRefinementJob();
        }
    }

    private function dispatchTrackRefinementJob()
    {
        RefineTracksJob::dispatch($this->albumRefinementQueue)->onQueue('prio_low');
        $this->trackRefinementQueue = [];
    }

    private function dispatchAlbumRefinementJob()
    {
        RefineAlbumsJob::dispatch($this->albumRefinementQueue)->onQueue('prio_low');
        $this->albumRefinementQueue = [];
    }

    private function dispatchArtistRefinementJob()
    {
        RefineArtistsJob::dispatch($this->albumRefinementQueue)->onQueue('prio_low');
        $this->artistRefinementQueue = [];
    }
}
