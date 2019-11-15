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
        $artistIds = $track->artists->pluck('id')->toArray();
        $artists = $this->pluckIdAndName($track->artists);

        return [
            'type' => 'track',
            'id' => $track->id,
            'name' => $track->name,
            'provider' => $track->provider,
            'spotify_id' => $track->spotify_id,
            'album' => ['id' => $track->album->id, 'name' => $track->album->name],
            'album_url' => route('getAlbum', ['id' => $track->album->id], false),
            'artists' => $artists,
            'artists_url' => route('getArtists', ['ids' => implode(',', $artistIds)], false),
            'audio_features_url' => route('getTrackAudioFeatures', ['id' => $track->id], false),
            'duration' => $track->duration,
            'duration_formatted' => formatDuration($track->duration),
            'rating' => $track->rating->rating ?? null,
        ];
    }
}
