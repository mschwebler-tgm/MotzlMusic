<?php

namespace App\Components\MyLibrary;

use App\Artist;
use Illuminate\Database\Eloquent\Builder;

class ArtistDao extends AbstractByLetterDao
{
    /** @return string AbstractItemByLetter::class */
    protected function getByLetterOccurrenceClass()
    {
        return ArtistByLetterOccurrence::class;
    }

    /** @return Builder */
    protected function baseQuery()
    {
        return Artist::ofCurrentUser();
    }
}
