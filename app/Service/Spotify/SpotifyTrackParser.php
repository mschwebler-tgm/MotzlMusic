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
            $result[$nestedPropName] = [];
            $remainingNestedPropNames = $this->getDescendingProperties($propName);
            $nestedObject = $this->getPropFromTrack($nestedPropName, $track);
            if ($this->isAsteriskWildCard($remainingNestedPropNames)) {
                $propToExtract = $this->getDescendingProperties($remainingNestedPropNames);
                $this->pushAllNestedProps($result[$nestedPropName], $nestedObject, $propToExtract);
            } else {
                $this->pushPropFromTrack($result[$nestedPropName], $nestedObject, $remainingNestedPropNames);
            }
        } else {
            $result[$propName] = $this->getPropFromTrack($propName, $track);
        }
    }

    private function pushAllNestedProps(&$result, $track, $propToExtract)
    {
        foreach ($track as $key => $wildCardItem) {
            $result[$key] = [];
            $this->pushPropFromTrack($result[$key], $wildCardItem, $propToExtract);
        }
    }

    private function getPropFromTrack($propName, $track)
    {
        if (is_array($track) && preg_match('/\d+/', $propName)) {
            return isset($track[(int)$propName]) ? $track[(int)$propName] : null;
        }
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

    private function isAsteriskWildCard($prop)
    {
        return $prop[0] === '*';
    }

    /**
     * @param $propName
     * @return bool|string
     */
    private function getDescendingProperties($propName)
    {
        return substr($propName, strpos($propName, '.') + 1);
    }
}
