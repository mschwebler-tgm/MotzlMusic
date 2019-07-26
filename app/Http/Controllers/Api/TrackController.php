<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\GenericDaos\TrackDao;
use App\SpotifyAudioFeature;

class TrackController extends Controller
{
    public function getDetails($id, TrackDao $trackDao)
    {
        return $trackDao->trackDetails($id);
    }

    public function audioFeatures($id)
    {
        return SpotifyAudioFeature::where('track_id', $id)->first();
    }
}
