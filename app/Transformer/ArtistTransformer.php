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
        $albumIds = $artist->albums->pluck('id')->toArray();
        if ($routePrefix === 'api/my') {
            $tracks = $artist->tracks()->ofCurrentUser()->get();
        } else {
            $tracks = $artist->tracks;
        }
        $tracks = $this->pluckIdAndName($tracks);
        $albums = $this->pluckIdAndName($artist->albums);

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
            'tracks' => $tracks,
            'tracks_url' => route('getArtistTracks', ['id' => $artist->id]),
            'albums' => $albums,
            'albums_url' => route('getAlbums', implode(',', $albumIds)),
        ];
    }
}
