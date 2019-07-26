<?php

namespace App\DTOs;

use App\Components\Spotify\Models\AudioFeatures as SpotifyAudioFeatures;
use App\SpotifyAudioFeature;

class AudioFeatureDTO implements SpotifyDTO
{
    public static function spotifyToModels($audioFeaturesResponse)
    {
        $audioFeatures = collect();
        foreach ($audioFeaturesResponse as $singleAudioFeatureResponse) {
            $audioFeatures->push(self::spotifyToModel($singleAudioFeatureResponse));
        }
        return $audioFeatures;
    }

    public static function spotifyToModel($audioFeatureResponse)
    {
        return new SpotifyAudioFeatures($audioFeatureResponse);
    }

    public static function singleAudioFeatureToApiResponse(SpotifyAudioFeature $audioFeature = null)
    {
        if (!$audioFeature) {
            return null;
        }

        return [
            'key' => $audioFeature->key,
            'mode' => $audioFeature->mode,
            'tempo' => $audioFeature->tempo,
            'energy' => $audioFeature->energy,
            'valence' => $audioFeature->valence,
            'liveness' => $audioFeature->liveness,
            'loudness' => $audioFeature->loudness,
            'speechiness' => $audioFeature->speechiness,
            'acousticness' => $audioFeature->acousticness,
            'danceability' => $audioFeature->danceability,
            'instrumentalness' => $audioFeature->instrumentalness,
        ];
    }
}
