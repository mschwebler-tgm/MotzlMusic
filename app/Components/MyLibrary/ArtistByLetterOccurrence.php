<?php

namespace App\Components\MyLibrary;

use App\Artist;

class ArtistByLetterOccurrence extends AbstractItemByLetter
{
    public function loadItems()
    {
        $this->items = Artist::ofCurrentUser()
            ->with('tracks')
            ->whereRaw("substr(UPPER(name), 1, 1) = '{$this->getLetter()}'")
            ->orderBy('name', 'asc')
            ->get();
    }
}
