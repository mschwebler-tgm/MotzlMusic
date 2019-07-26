<?php

namespace App\Components\MyLibrary;

use App\Album;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class AlbumDao extends AbstractByLetterDao
{
    public function getAlbums()
    {
        $albums = Album::ofCurrentUser()
            ->with('artists')
            ->orderBy('name', 'asc')
            ->get();

        return $albums;
    }

    protected function getByLetterOccurrenceClass()
    {
        return AlbumByLetterOccurrence::class;
    }

    protected function baseQuery()
    {
        return Album::ofCurrentUser();
    }
}
