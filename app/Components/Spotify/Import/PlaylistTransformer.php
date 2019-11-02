<?php

namespace App\Components\Spotify\Import;

use App\Service\GenericTransformer;
use App\Transformer\Transformable;

class PlaylistTransformer extends Transformable
{
    protected function transformItem($item)
    {
        $resultFormatter = new GenericTransformer($item);
        return $resultFormatter->get('name', 'id', 'owner', 'href', ['tracks.total' => 'tracks'], ['images.1.url' => 'image']);
    }
}
