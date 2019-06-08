<?php

namespace App\Components\Spotify\Import;

use App\Components\Spotify\Models\Track as SpotifyTrack;
use App\Components\Spotify\Refinement\RefinementQueue;
use App\Components\Spotify\SpotifyDao;
use App\Track;
use App\User;
use Illuminate\Support\Collection;

class TrackImportService
{
    private $spotifyDao;
    private $refinementQueue;

    public function __construct(SpotifyDao $spotifyDao, RefinementQueue $refinementQueue)
    {
        $this->spotifyDao = $spotifyDao;
        $this->refinementQueue = $refinementQueue;
    }

    public function setCurrentUser(User $user)
    {
        $this->refinementQueue->setUser($user);
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
            $this->refinementQueue->addToBuffer($track, $album, $artists);
            $this->refinementQueue->dispatchJobsIfNeeded();
            $tracks->push($track);
        }
        $this->refinementQueue->dispatchJobsIfNeeded(true);

        return $tracks;
    }

    /**
     * @param SpotifyTrack $track
     * @param User $user
     * @return Track
     */
    public function storeTrackForUser(SpotifyTrack $track, User $user)
    {
        return $this->saveTracksForUser(collect([$track]), $user)->first();
    }
}
