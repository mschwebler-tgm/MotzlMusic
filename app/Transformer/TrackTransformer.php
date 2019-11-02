<?php

namespace App\Transformer;

use App\Track;

class TrackTransformer extends Transformable
{
    /**
     * @param $track Track
     * @return array
     */
    protected function transformItem($track)
    {
        $data = $track->toArray();
        $artistIds = $track->artists->pluck('id')->toArray();
        $data['album'] = $track->album->id;
        $data['album_url'] = route('getAlbum', ['id' => $track->album->id]);
        $data['artists'] = $artistIds;
        $data['artists_url'] = route('getArtists', ['ids' => implode(',', $artistIds)]);
        $data['audio_features_url'] = route('getTrackAudioFeatures', ['id' => $track->id]);
        $data['duration_formatted'] = formatDuration($track->duration);
        $data['rating'] = $track->rating->rating ?? null;
        $data['type'] = 'track';

        return $data;
    }
}
