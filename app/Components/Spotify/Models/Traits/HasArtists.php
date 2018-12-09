<?php

namespace App\Components\Spotify\Models\Traits;

use App\Components\Spotify\Models\Artist;

trait HasArtists
{
    protected function setArtistsFromResponse($artists): void
    {
        if ($artists === null) {
            return;
        }

        $artistCollection = collect();
        foreach ($artists as $artist) {
            $artistCollection->push(new Artist($artist));
        }
        $this->artists = $artistCollection;
    }
}
