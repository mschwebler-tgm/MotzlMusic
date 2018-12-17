<?php

namespace App\DTOs;

use App\Components\Spotify\Models\AudioFeatures as SpotifyAudioFeatures;

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
}
