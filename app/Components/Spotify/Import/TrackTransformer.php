<?php

namespace App\Components\Spotify\Import;

use App\Service\Spotify\ResultFormatter;

class TrackTransformer
{
    public function transform($tracks)
    {
        $transformedItems = [];
        foreach ($tracks as $track) {
            $transformedItems[] = $this->transformItem($track);
        }
        return $transformedItems;
    }

    private function transformItem($track)
    {
        $resultFormatter = new ResultFormatter($track->track);
        return $resultFormatter->get('name', ['artists.0.name' => 'artist'], 'id', 'uri', ['duration_ms' => 'duration']);
    }
}
