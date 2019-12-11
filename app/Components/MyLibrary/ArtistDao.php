<?php

namespace App\Components\MyLibrary;

use App\Artist;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ArtistDao extends AbstractByLetterDao
{
    public function getTracksForArtist($id): Collection
    {
        $artist = Artist::findOrFail($id);
        return $artist->tracks;
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
