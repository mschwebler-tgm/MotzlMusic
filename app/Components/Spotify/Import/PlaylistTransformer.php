<?php

namespace App\Components\Spotify\Import;

use App\Service\Spotify\ResultFormatter;

class PlaylistTransformer
{
    public function transform($items)
    {
        $transformedItems = [];
        foreach ($items as $item) {
            $transformedItems[] = $this->transformItem($item);
        }
        return $transformedItems;
    }

    private function transformItem($item)
    {
        $resultFormatter = new ResultFormatter($item);
        return $resultFormatter->get('name', 'id', 'owner', 'href', ['tracks.total' => 'tracks'], ['images.1.url' => 'image']);
    }
}
