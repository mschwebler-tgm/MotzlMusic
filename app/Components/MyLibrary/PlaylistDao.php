<?php

namespace App\Components\MyLibrary;

use App\Playlist;

class PlaylistDao
{
    public function getAll()
    {
        return Playlist::where('user_id', apiUser()->id)->get();
    }
}
