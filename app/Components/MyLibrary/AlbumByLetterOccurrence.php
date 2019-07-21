<?php

namespace App\Components\MyLibrary;

use App\Album;
use App\Daos\AudioFeatureDao;

class AlbumByLetterOccurrence extends AbstractItemByLetter
{
    public function loadItems()
    {
        $this->items = Album::ofCurrentUser()
            ->with('tracks.artists')
            ->whereRaw("substr(UPPER(name), 1, 1) = '{$this->getLetter()}'")
            ->orderBy('name', 'asc')
            ->get();

        app(AudioFeatureDao::class)->addAverageAudioFeaturesTo($this->items);
    }
}
