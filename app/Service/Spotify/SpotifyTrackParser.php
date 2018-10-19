<?php

namespace App\Service\Spotify;


class SpotifyTrackParser
{
    private $track;

    public function __construct($track)
    {
        $this->track = $track;
    }

    public function get(...$props)
    {
        $result = [];
        foreach (func_get_args() as $prop) {
            $result[$prop] = $this->getPropFromTrack($prop);
        }
        return $result;
    }

    private function getPropFromTrack($prop)
    {
        return isset($this->track->$prop) ? $this->track->$prop : null;
    }
}
