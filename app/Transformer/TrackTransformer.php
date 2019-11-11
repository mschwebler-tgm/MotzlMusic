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
        $artists = $this->pluckIdAndName($track->artists);

        $data['album'] = [
            'id' => $track->album->id,
            'name' => $track->album->name,
        ];
        $data['album_url'] = route('getAlbum', ['id' => $track->album->id], false);
        $data['artists'] = $artists;
        $data['artists_url'] = route('getArtists', ['ids' => implode(',', $artistIds)], false);
        $data['audio_features_url'] = route('getTrackAudioFeatures', ['id' => $track->id], false);
        $data['duration_formatted'] = formatDuration($track->duration);
        $data['rating'] = $track->rating->rating ?? null;
        $data['type'] = 'track';

        return $data;
    }
}
