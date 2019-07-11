<?php

namespace App\Daos;

use App\Playlist;
use App\SpotifyAudioFeature;
use Illuminate\Support\Collection;

class PlaylistDao
{
    public function addAudioFeatures(Collection $playlists)
    {
        return $playlists->map(function (Playlist $playlist) {
            return $playlist->setAttribute('audio_features', $this->getAverageAudioFeatures($playlist));
        });
    }

    private function getAverageAudioFeatures(Playlist $playlist)
    {
        $audioFeatures = $playlist->tracks()->with('audioFeatures')->get()->pluck('audioFeatures');

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
