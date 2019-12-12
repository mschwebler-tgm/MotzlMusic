<?php

namespace App\Service\GenericDaos;

use App\Artist;
use App\Components\MyLibrary\AbstractByLetterDao;
use App\Components\MyLibrary\ArtistByLetterOccurrence;

class ArtistDao extends AbstractByLetterDao
{
    public function get($id)
    {
        return Artist::findOrFail($id);
    }

    public function getMultiple(array $ids)
    {
        return Artist::with('tracks')->whereIn('id', $ids)->get();
    }

    public function tracksForArtist($artistId)
    {
        return Artist::with('tracks')->findOrFail($artistId)->tracks;
    }

    public function albumsForArtist($artistId)
    {
        return Artist::with('albums')->findOrFail($artistId)->albums;
    }

    public function getSingleTracksIds()
    {
        return Artist::join('track_has_artist', 'track_has_artist.artist_id', '=', 'artists.id')
            ->join('tracks', 'track_has_artist.track_id', '=', 'tracks.id')
            ->selectRaw('COUNT(tracks.id) AS track_amount')
            ->addSelect(\DB::raw('MAX(tracks.id) as track_id'))
            ->groupBy('artists.id')
            ->having('track_amount', '=', 1)
            ->get('track_id')
            ->pluck('track_id')
            ->toArray();
    }

    /** @return string AbstractItemByLetter::class */
    protected function getByLetterOccurrenceClass()
    {
        return ArtistByLetterOccurrence::class;
    }

    protected function baseQuery()
    {
        return Artist::query();
    }
}
