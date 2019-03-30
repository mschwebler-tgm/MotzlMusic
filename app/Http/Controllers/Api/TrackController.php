<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\SpotifyAudioFeature;

class TrackController extends Controller
{
    public function audioFeatures($id)
    {
        return SpotifyAudioFeature::where('track_id', $id)->first();
    }
}
