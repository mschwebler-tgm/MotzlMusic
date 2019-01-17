<?php

namespace App\Http\Controllers\Player;

use App\Http\Controllers\Controller;

class SpotifyPlayerController extends Controller
{
    public function playTrack()
    {
        $trackId = request('track_id');
        $deviceId = request('device_id');

        dd($trackId, $deviceId);
    }
}
