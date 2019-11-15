<?php

namespace App\Components\MyLibrary;

use App\Artist;
use App\Track;
use Illuminate\Database\Eloquent\Builder;

class ArtistDao extends AbstractByLetterDao
{
    public function getSingleTracks()
    {
        $trackIds = Artist::ofCurrentUser()
            ->join('track_has_artist', 'track_has_artist.artist_id', '=', 'artists.id')
            ->join('tracks', 'track_has_artist.track_id', '=', 'tracks.id')
            ->selectRaw('COUNT(tracks.id) AS track_amount')
            ->addSelect(\DB::raw('MAX(tracks.id) as track_id'))
            ->groupBy('artists.id')
            ->having('track_amount', '=', 1)
            ->get('track_id')
            ->pluck('track_id')
            ->toArray();

        return Track::ofCurrentUser()
            ->whereIn('id', $trackIds)
            ->get();
    }

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
