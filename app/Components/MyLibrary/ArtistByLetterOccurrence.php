<?php

namespace App\Components\MyLibrary;

use App\Artist;

class ArtistByLetterOccurrence extends AbstractItemByLetter
{
    public function loadIds()
    {
        $this->items = Artist::with('tracks.artists', 'tracks.album')
            ->whereRaw("substr(UPPER(name), 1, 1) = '{$this->getLetter()}'")
            ->orderBy('name', 'asc')
            ->get('id')
            ->pluck('id');
    }
}
