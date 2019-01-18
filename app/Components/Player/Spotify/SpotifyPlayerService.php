<?php

namespace App\Components\Player\Spotify;

use App\Service\Spotify\SpotifyApiService;
use App\Track;

class SpotifyPlayerService
{
    private $apiService;
    private $playerDao;

    public function __construct(SpotifyApiService $apiService, SpotifyPlayerDao $playerDao)
    {
        $this->apiService = $apiService;
        $this->playerDao = $playerDao;
    }

    /**
     * @param $trackId string: spotify_id of track
     * @param $deviceId string: spotifyConnect device id
     */
    public function playTrack($trackId, $deviceId)
    {
        /** @var Track $track */
        $track = $this->playerDao->getTrackById($trackId);
        $options = $this->generatePlayOptionsFor($track);
        $this->apiService->play($deviceId, $options);
    }

    /**
     * As the spotify api only allows playing albums or artists, this method generates options to play the album at
     * a specific offset that matches the track.
     *
     * @param $track Track
     * @return array
     */
    private function generatePlayOptionsFor(Track $track): array
    {
        $options = [
            'context_uri' => $track->album->spotify_uri,
            'offset' => [
                'position' => $track->spotify_track_number,
            ],
        ];
        return $options;
    }
}