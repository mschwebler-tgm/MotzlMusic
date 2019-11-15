<?php

namespace App\Service\GenericDaos;

use App\Artist;

class ArtistDao
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
}
