<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RatingRequest;
use App\Http\Requests\SortRequest;
use App\Service\GenericDaos\Exceptions\TrackNotFoundException;
use App\Service\GenericDaos\TrackDao;
use App\SpotifyAudioFeature;
use App\Transformer\TrackTransformer;

class TrackController extends Controller
{
    /**
     * @param $id
     * @param TrackDao $trackDao
     * @param TrackTransformer $transformer
     * @return array
     * @throws TrackNotFoundException
     */
    public function get($id, TrackDao $trackDao, TrackTransformer $transformer)
    {
        return $transformer->transform($trackDao->get($id));
    }

    public function tracks($ids, TrackDao $trackDao, TrackTransformer $transformer)
    {
        $ids = explode(',', $ids);
        return $transformer->transform($trackDao->tracks($ids));
    }

    public function audioFeatures($id)
    {
        return SpotifyAudioFeature::where('track_id', $id)->first();
    }

    public function rateTrack($id, RatingRequest $request, TrackDao $trackDao)
    {
        $trackDao->setUserRating($id, apiUser()->id, $request->getRating());
    }

    public function sort(SortRequest $request, TrackDao $trackDao, TrackTransformer $transformer)
    {
        $tracks = $trackDao->getSorted($request->getTrackIds(), $request->getSorting());

        return $transformer->transform($tracks);
    }
}
