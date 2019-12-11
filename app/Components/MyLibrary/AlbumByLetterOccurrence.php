<?php

namespace App\Components\MyLibrary;

use App\Album;

class AlbumByLetterOccurrence extends AbstractItemByLetter
{
    public function loadIds()
    {
        $this->items = Album::whereRaw("substr(UPPER(name), 1, 1) = '{$this->getLetter()}'")
            ->orderBy('name', 'asc')
            ->get('id')
            ->pluck('id');
    }
}
