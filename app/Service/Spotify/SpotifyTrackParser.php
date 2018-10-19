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
            $this->pushPropFromTrack($result, $this->track, $prop);
        }
        return $result;
    }

    private function pushPropFromTrack(&$result, $track, $propName)
    {
        if (str_contains($propName, '.')) {
            $nestedPropName = $this->getFirstNestedProp($propName);
            $remainingNestedPropNames = substr($propName, strlen($nestedPropName) + 1, strlen($propName) - strlen($nestedPropName));
            $result[$nestedPropName] = [];
            $nestedObject = $this->getPropFromTrack($nestedPropName, $track);
            $this->pushPropFromTrack($result[$nestedPropName], $nestedObject, $remainingNestedPropNames);
        } else {
            $result[$propName] = $this->getPropFromTrack($propName, $track);
        }
    }

    private function getPropFromTrack($propName, $track)
    {
        return isset($track->$propName) ? $track->$propName : null;
    }

    /**
     * returns the first nested property found in string
     * ex: artist.nestedObject.name
     * returns: artist
     * @param $prop
     * @return string
     */
    private function getFirstNestedProp($prop)
    {
        return explode('.', $prop)[0];
    }
}
