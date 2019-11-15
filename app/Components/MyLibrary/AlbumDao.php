<?php

namespace App\Components\MyLibrary;

use App\Album;
use App\Track;

class AlbumDao extends AbstractByLetterDao
{
    public function getAlbums()
    {
        return Album::ofCurrentUser()
            ->with('artists')
            ->orderBy('name', 'asc')
            ->get();
    }

    public function getSingleTracks()
    {
        $trackIds = Album::ofCurrentUser()
            ->join('tracks', 'tracks.album_id', '=', 'albums.id')
            ->selectRaw('COUNT(tracks.id) AS track_amount')
            ->addSelect(\DB::raw('MAX(tracks.id) as track_id'))
            ->groupBy('albums.id')
            ->having('track_amount', '=', 1)
            ->get('track_id')
            ->pluck('track_id')
            ->toArray();

        return Track::ofCurrentUser()
            ->whereIn('id', $trackIds)
            ->get();
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
