<?php

namespace App\Components\Upload\Matcher;

use App\Components\Spotify\Models\Artist;
use App\Components\Spotify\Models\Track;
use App\Components\Spotify\Api\SpotifyApi;
use Illuminate\Support\Str;

class SpotifyMatcher
{
    private $spotifyApi;

    const IGNORED_STRINGS = [
        'official',
        'lyrics',
    ];
    const LEVENSHTEIN_LIMIT = 10;

    public function __construct(SpotifyApi $spotifyApi)
    {
        $this->spotifyApi = $spotifyApi;
    }

    public function getEstimatedSpotifyMatch(string $trackName)
    {
        $trackName = $this->cutDisturbingStrings($trackName);
        $results = $this->spotifyApi->search($trackName, 'track')->tracks->items;
        if (empty($results)) {
            return null;
        }

        $spotifyTrack = new Track($results[0]);
        $trackMatches = $this->isSimilarEnoughForMatch($trackName, $spotifyTrack);

        return $trackMatches ? $spotifyTrack : null;
    }

    private function cutDisturbingStrings(string $trackName)
    {
        $trackName = strtolower($trackName);

        // disc numbers like "01 - 3 doors down - kryptonite"
        if (preg_match('/^\d{1,2} ?-/', $trackName, $matches)) {
            $trackName = str_replace($matches[0], '', $trackName);
        }

        $parenthesises = [];
        if (!preg_match('/[\(\[].*[\)\]]/', $trackName, $parenthesises)) {
            return $trackName;
        };

        foreach ($parenthesises as $parenthesis) {
            if (Str::contains($parenthesis, self::IGNORED_STRINGS)) {
                $trackName = str_replace($parenthesis, '', $trackName);
            };
        }

        return $trackName;
    }

    private function isSimilarEnoughForMatch(string $inputTrackName, Track $spotifyTrack)
    {
        $inputTrackName = $this->unifyTrackName($inputTrackName);
        $inputTrackName = $this->removeArtistFromName($inputTrackName, $spotifyTrack->artists->first());
        $spotifyTrackName = $this->unifyTrackName($spotifyTrack->name);

        if (Str::contains($inputTrackName, $spotifyTrackName)) {
            return true;
        }
        if (Str::contains($spotifyTrackName, $inputTrackName)) {
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
        return preg_replace('/[^a-z0-9]/', '', $name);
    }
}
