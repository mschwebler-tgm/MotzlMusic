<?php

namespace App\Components\Spotify\Refinement;

use App\Album;
use App\Track;
use App\Components\Spotify\Refinement\Jobs\RefineAlbumsJob;
use App\Components\Spotify\Refinement\Jobs\RefineArtistsJob;
use App\Components\Spotify\Refinement\Jobs\RefineTracksJob;
use App\User;
use Illuminate\Support\Collection;

class RefinementQueue
{
    const MAX_QUEUE_LIMIT = 20;

    private $trackRefinementQueue = [];
    private $albumRefinementQueue = [];
    private $artistRefinementQueue = [];
    private $user;

    public function addToBuffer(Track $track, Album $album, Collection $artists)
    {
        $this->trackRefinementQueue = array_unique(array_merge($this->trackRefinementQueue, [$track->spotify_id]));
        $this->albumRefinementQueue = array_unique(array_merge($this->albumRefinementQueue, [$album->spotify_id]));
        $this->artistRefinementQueue = array_unique(array_merge($this->artistRefinementQueue, $artists->pluck('spotify_id')->toArray()));
        $this->dispatchJobsIfNeeded();
    }

    public function dispatchJobsIfNeeded($force = false)
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
        if ($this->trackRefinementQueue) {
            RefineTracksJob::dispatch($this->trackRefinementQueue, $this->user)->onQueue('prio_low');
            $this->trackRefinementQueue = [];
        }
    }

    private function dispatchAlbumRefinementJob()
    {
        if ($this->albumRefinementQueue) {
            RefineAlbumsJob::dispatch($this->albumRefinementQueue, $this->user)->onQueue('prio_low');
            $this->albumRefinementQueue = [];
        }
    }

    private function dispatchArtistRefinementJob()
    {
        if ($this->artistRefinementQueue) {
            RefineArtistsJob::dispatch($this->artistRefinementQueue, $this->user)->onQueue('prio_low');
            $this->artistRefinementQueue = [];
        }
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }
}