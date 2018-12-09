<?php

namespace App\Components\Spotify\Import;

use App\Components\Spotify\Models\Track as SpotifyTrack;
use Illuminate\Support\Collection;

class TrackImportService
{
    private $trackImporterDao;

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
        }
    }
}
