<?php

namespace App\Transformer;

use App\Album;

class AlbumTransformer extends Transformable
{
    /**
     * @param $album Album
     * @return array
     */
    protected function transformItem($album)
    {
        $routePrefix = request()->route()->getPrefix();
        $artistIds = $album->artists()->get()->pluck('id')->toArray();
        if ($routePrefix === 'api/my') {
            $tracks = $album->tracks()->ofCurrentUser()->get();
        } else {
            $tracks = $album->tracks;
        }
        $tracks = $this->pluckIdAndName($tracks);
        $artists = $this->pluckIdAndName($album->artists);

        return [
            'id' => $album->id,
            'name' => $album->name,
            'popularity' => $album->popularity,
            'label' => $album->label,
            'release_date' => $album->release_date,
            'spotify_id' => $album->spotify_id,
            'spotify_image_small' => $album->spotify_image_small,
            'spotify_image_medium' => $album->spotify_image_medium,
            'spotify_image_large' => $album->spotify_image_large,
            'audio_features_url' => route('getAlbumAudioFeatures', ['id' => $album->id], false),
            'tracks' => $tracks,
            'tracks_url' => route('getAlbumTracks', ['id' => $album->id], false),
            'artists' => $artists,
            'artists_url' => route('getArtists', ['ids' => join(',', $artistIds)], false),
        ];
    }
}
