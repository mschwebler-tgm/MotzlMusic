<?php

namespace App\Components\Spotify\Import;


use App\Service\GenericTransformer;
use App\Transformer\Transformable;

class AlbumTransformer extends Transformable
{
    protected function transformItem($album)
    {
        $resultFormatter = new GenericTransformer($album);
        return $resultFormatter->get(
            ['album.name' => 'name'],
            ['album.id' => 'id'],
            ['album.release_date' => 'release_date'],
            ['album.images.1.url' => 'image'],
            ['album.artists.0.name' => 'artist'],
            ['album.total_tracks' => 'tracks'],
            ['album.uri' => 'uri']
        );
    }
}
