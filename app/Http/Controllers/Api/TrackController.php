<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RatingRequest;
use App\Service\GenericDaos\TrackDao;
use App\SpotifyAudioFeature;

class TrackController extends Controller
{
    public function get($id, TrackDao $trackDao)
    {
        return $trackDao->get($id);
    }

    public function audioFeatures($id)
    {
        return SpotifyAudioFeature::where('track_id', $id)->first();
    }

    public function rateTrack($id, RatingRequest $request, TrackDao $trackDao)
    {
        $trackDao->setUserRating($id, apiUser()->id, $request->getRating());
    }
}
