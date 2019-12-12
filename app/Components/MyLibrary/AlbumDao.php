<?php

namespace App\Components\MyLibrary;

use App\Album;

class AlbumDao extends AbstractByLetterDao
{
    public function getSingleTrackIds()
    {
        return Album::join('tracks', 'tracks.album_id', '=', 'albums.id')
            ->selectRaw('COUNT(tracks.id) AS track_amount')
            ->addSelect(\DB::raw('MAX(tracks.id) as track_id'))
            ->groupBy('albums.id')
            ->having('track_amount', '=', 1)
            ->get('track_id')
            ->pluck('track_id')
            ->toArray();
    }

    protected function getByLetterOccurrenceClass()
    {
        return AlbumByLetterOccurrence::class;
    }

    protected function baseQuery()
    {
        return Album::query();
    }
}
