<?php

namespace App\Service\GenericDaos;

use App\Service\GenericDaos\Exceptions\TrackNotFoundException;
use App\Track;

class TrackDao
{
    /**
     * @param $id
     * @return Track
     * @throws TrackNotFoundException
     */
    public function get($id)
    {
        $track = Track::find($id);
        if (!$track) {
            throw new TrackNotFoundException("ID: $id");
        }

        return $track;
    }

    public function trackDetails($id)
    {
        return Track::with('artists', 'album')->find($id);
    }
}