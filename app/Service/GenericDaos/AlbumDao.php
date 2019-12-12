<?php

namespace App\Service\GenericDaos;

use App\Album;
use App\Components\MyLibrary\AbstractByLetterDao;
use App\Components\MyLibrary\AlbumByLetterOccurrence;

class AlbumDao extends AbstractByLetterDao
{
    public function get($id): Album
    {
        return Album::with('tracks')->findOrFail($id);
    }

    public function getMultiple(array $ids)
    {
        return Album::with('tracks')->whereIn('id', $ids)->get();
    }

    public function tracksForAlbum($albumId)
    {
        return Album::with('tracks')->findOrFail($albumId)->tracks;
    }

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
