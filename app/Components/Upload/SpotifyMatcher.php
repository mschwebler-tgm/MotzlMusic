<?php

namespace App\Components\Upload;


use App\Components\Spotify\Models\Artist;
use App\Components\Spotify\Models\Track;
use App\Service\Spotify\SpotifyApiService;

class SpotifyMatcher
{
    private $apiService;

    const LEVENSHTEIN_LIMIT = 10;

    public function __construct(SpotifyApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function getEstimatedSpotifyMatch(string $trackName)
    {
        $results = $this->apiService->search($trackName, 'track')->tracks->items;
        if (empty($results)) {
            return null;
        }

        $spotifyTrack = new Track($results[0]);
        $trackMatches = $this->isSimilarEnoughForMatch($trackName, $spotifyTrack);
        dd($trackMatches);
    }

    private function isSimilarEnoughForMatch(string $inputTrackName, Track $spotifyTrack)
    {
        $inputTrackName = $this->unifyTrackName($inputTrackName);
        $inputTrackName = $this->removeArtistFromName($inputTrackName, $spotifyTrack->artists->first());
        $spotifyTrackName = $this->unifyTrackName($spotifyTrack->name);

        if (str_contains($inputTrackName, $spotifyTrackName)) {
            return true;
        }
        if (str_contains($spotifyTrackName, $inputTrackName)) {
            return true;
        }

        return levenshtein($inputTrackName, $spotifyTrackName) < self::LEVENSHTEIN_LIMIT;
    }

    private function removeArtistFromName(string $inputTrackName, Artist $artist)
    {
        $artistName = strtolower($artist->name);
        $position = strpos($inputTrackName, $artistName);
        if ($position === false) {
            return $inputTrackName;
        }

        return substr_replace($inputTrackName, '', 0, strlen($artistName));
    }

    /**
     * Removes any special characters + lower case
     *
     * @param string $name
     * @return string|string[]|null
     */
    private function unifyTrackName(string $name)
    {
        return strtolower(preg_replace('/[^A-Za-z0-9]/', '', $name));
    }
}