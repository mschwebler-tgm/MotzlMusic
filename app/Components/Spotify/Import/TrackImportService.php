<?php

namespace App\Components\Spotify\Import;

use App\Album;
use App\Components\Spotify\Models\Track as SpotifyTrack;
use App\Components\Spotify\Refinement\Jobs\RefineAlbumsJob;
use App\Components\Spotify\Refinement\Jobs\RefineArtistsJob;
use App\Components\Spotify\Refinement\Jobs\RefineTracksJob;
use App\Components\Spotify\SpotifyDao;
use App\Track;
use App\User;
use Illuminate\Support\Collection;

class TrackImportService
{
    private $currentUser;
    private $spotifyDao;
    private $trackRefinementQueue = [];
    private $albumRefinementQueue = [];
    private $artistRefinementQueue = [];

    const MAX_QUEUE_LIMIT = 20;

    public function __construct(SpotifyDao $spotifyDao)
    {
        $this->spotifyDao = $spotifyDao;
    }

    public function setCurrentUser(User $user)
    {
        $this->currentUser = $user;
    }

    public function saveTracksForUser(Collection $spotifyTracks, User $user)
    {
        $tracks = collect();
        /** @var SpotifyTrack $spotifyTrack */
        foreach ($spotifyTracks as $spotifyTrack) {
            $artists = $this->spotifyDao->storeArtists($spotifyTrack->artists);
            $album = $this->spotifyDao->storeAlbum($spotifyTrack->album);
            $track = $this->spotifyDao->storeTrack($spotifyTrack, $user, $album->id);
            $track->artists()->sync($artists->pluck('id'));
            $album->artists()->sync($artists->pluck('id'));
            $this->addToRefinementQueue($track, $album, $artists);
            $tracks->push($track);
        }
        $this->dispatchRefinementJobs(true);

        return $tracks;
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
        if ($this->trackRefinementQueue) {
            RefineTracksJob::dispatch($this->trackRefinementQueue, $this->currentUser)->onQueue('prio_low');
            $this->trackRefinementQueue = [];
        }
    }

    private function dispatchAlbumRefinementJob()
    {
        if ($this->albumRefinementQueue) {
            RefineAlbumsJob::dispatch($this->albumRefinementQueue, $this->currentUser)->onQueue('prio_low');
            $this->albumRefinementQueue = [];
        }
    }

    private function dispatchArtistRefinementJob()
    {
        if ($this->artistRefinementQueue) {
            RefineArtistsJob::dispatch($this->artistRefinementQueue, $this->currentUser)->onQueue('prio_low');
            $this->artistRefinementQueue = [];
        }
    }
}
