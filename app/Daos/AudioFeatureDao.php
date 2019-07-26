<?php

namespace App\Daos;

use App\HasTracks;
use App\SpotifyAudioFeature;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class AudioFeatureDao
{
    /**
     * @param Collection $hasTracksModels
     * @return Collection
     */
    public function addAverageAudioFeaturesTo(Collection $hasTracksModels)
    {
        return $hasTracksModels->map(function (Model $hasTracksModel) {
            return $hasTracksModel->setAttribute('audio_features', $this->getCachedAverageAudioFeatures($hasTracksModel));
        });
    }

    /**
     * @param HasTracks|Model $hasTracksModel
     * @return mixed
     */
    private function getCachedAverageAudioFeatures(HasTracks $hasTracksModel)
    {
        $cacheKey = __METHOD__ . "_" . get_class($hasTracksModel) . "_{$hasTracksModel->id}";
        $audioFeatures = Cache::get($cacheKey);
        if (!$audioFeatures) {
            $audioFeatures = $this->getAverageAudioFeatures($hasTracksModel);
            Cache::put($cacheKey, $audioFeatures, 120);
        }

        return $audioFeatures;
    }

    /**
     * @param HasTracks|Model $hasTracksModel
     * @return SpotifyAudioFeature
     */
    private function getAverageAudioFeatures(HasTracks $hasTracksModel)
    {
        $audioFeatures = $hasTracksModel->tracks()->with('audioFeatures')->get()->pluck('audioFeatures');

        return new SpotifyAudioFeature([
            'valence' => $this->averageAudioFeature($audioFeatures, 'valence'),
            'danceability' => $this->averageAudioFeature($audioFeatures, 'danceability'),
            'speechiness' => $this->averageAudioFeature($audioFeatures, 'speechiness'),
            'acousticness' => $this->averageAudioFeature($audioFeatures, 'acousticness'),
            'instrumentalness' => $this->averageAudioFeature($audioFeatures, 'instrumentalness'),
            'energy' => $this->averageAudioFeature($audioFeatures, 'energy'),
        ]);
    }

    private function averageAudioFeature(Collection $features, $field)
    {
        return round($features->pluck($field)->avg(), 2);
    }
}
