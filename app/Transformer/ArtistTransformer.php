<?php

namespace App\Transformer;

use App\Artist;

class ArtistTransformer extends Transformable
{
    /**
     * @param $artist Artist
     * @return array
     */
    protected function transformItem($artist)
    {
        $routePrefix = request()->route()->getPrefix();
        if ($routePrefix === 'api/my') {
            $trackIds = $artist->tracks()->ofCurrentUser()->get()->pluck('id')->toArray();
        } else {
            $trackIds = $artist->tracks->pluck('id')->toArray();
        }

        return [
            'type' => 'artist',
            'id' => $artist->id,
            'name' => $artist->name,
            'popularity' => $artist->popularity,
            'spotify_id' => $artist->spotify_id,
            'spotify_image_small' => $artist->spotify_image_small,
            'spotify_image_medium' => $artist->spotify_image_medium,
            'spotify_image_large' => $artist->spotify_image_large,
            'audio_features' => $artist->audio_features ?? null,
            'tracks' => $trackIds,
        ];
    }
}
