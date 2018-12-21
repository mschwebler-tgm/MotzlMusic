<?php

namespace App\Http\Controllers\Personal;

use App\Components\MyLibrary\PlaylistDao;
use App\Http\Controllers\Controller;

class MyLibraryController extends Controller
{
    public function myPlaylists(PlaylistDao $playlistDao)
    {
        return $playlistDao->getAll();
    }
}
