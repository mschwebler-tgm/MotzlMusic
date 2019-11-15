<?php

namespace App\Service\GenericDaos;

use App\Album;

class AlbumDao
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
}
