<?php

namespace App\Components\Spotify\Import;

use App\Service\GenericTransformer;
use App\Transformer\Transformable;

class TrackTransformer extends Transformable
{
    protected function transformItem($track)
    {
        $resultFormatter = new GenericTransformer($track->track);
        return $resultFormatter->get('name', ['artists.0.name' => 'artist'], 'id', 'uri', ['duration_ms' => 'duration']);
    }
}
