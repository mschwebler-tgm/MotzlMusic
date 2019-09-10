<?php

namespace App\Components\MyLibrary;

use App\Artist;
use App\Daos\AudioFeatureDao;

class ArtistByLetterOccurrence extends AbstractItemByLetter
{
    public function loadItems()
    {
        $this->items = Artist::ofCurrentUser()
            ->with('tracks.artists', 'tracks.album')
            ->whereRaw("substr(UPPER(name), 1, 1) = '{$this->getLetter()}'")
            ->orderBy('name', 'asc')
            ->get();

        app(AudioFeatureDao::class)->addAverageAudioFeaturesTo($this->items);
    }
}
