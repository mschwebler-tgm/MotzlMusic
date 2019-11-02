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
            $trackIds = $album->tracks()->ofCurrentUser()->get()->pluck('id')->toArray();
        } else {
            $trackIds = $album->tracks->pluck('id')->toArray();
        }

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
            'audio_features' => $album->audio_features ?? null,
            'tracks' => $trackIds,
            'tracks_url' => route('getAlbumTracks', ['id' => $album->id]),
            'artists' => $artistIds,
            'artists_url' => route('getArtists', ['ids' => join(',', $artistIds)]),
        ];
    }
}
