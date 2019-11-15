<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\GenericDaos\ArtistDao;
use App\Service\GenericDaos\AudioFeatureDao;
use App\Transformer\ArtistTransformer;
use App\Transformer\TrackTransformer;

class ArtistController extends Controller
{
    public function artist($id, ArtistDao $artistDao, ArtistTransformer $transformer)
    {
        $artist = $artistDao->get($id);

        return $transformer->transform($artist);
    }

    public function artists($ids, ArtistDao $artistDao, ArtistTransformer $transformer)
    {
        $ids = explode(',', $ids);
        $artists = $artistDao->getMultiple($ids);

        return $transformer->transform($artists);
    }

    public function tracks($id, ArtistDao $artistDao, TrackTransformer $transformer)
    {
        $tracks = $artistDao->tracksForArtist($id);

        return $transformer->transform($tracks);
    }

    public function audioFeatures($id, ArtistDao $artistDao, AudioFeatureDao $audioFeatureDao)
    {
        $artist = $artistDao->get($id);
        return $audioFeatureDao->getCachedAverageAudioFeatures($artist);
    }
}
