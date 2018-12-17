<?php

namespace App\Components\Spotify\Import;

use App\Components\Spotify\Models\Track as SpotifyTrack;
use App\Components\Spotify\Refinement\RefinementQueue;
use App\Components\Spotify\SpotifyDao;
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
}
