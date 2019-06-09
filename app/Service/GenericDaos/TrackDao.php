<?php

namespace App\Service\GenericDaos;

use App\Track;

class TrackDao
{
    public function trackDetails($id)
    {
        return Track::with('artists', 'album')->find($id);
    }
}