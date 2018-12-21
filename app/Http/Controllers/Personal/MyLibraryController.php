<?php

namespace App\Http\Controllers\Personal;

use App\Components\MyLibrary\MyLibraryDao;
use App\Http\Controllers\Controller;

class MyLibraryController extends Controller
{
    private $libraryDao;

    public function __construct(MyLibraryDao $libraryDao)
    {
        $this->libraryDao = $libraryDao;
    }

    public function myPlaylists()
    {
        return $this->libraryDao->getAllPlaylists();
    }

    public function myTracks()
    {
        return $this->libraryDao->getAllTracks();
    }

    public function myArtists()
    {
        return $this->libraryDao->getAllArtists();
    }

    public function myAlbums()
    {
        return $this->libraryDao->getAllAlbums();
    }
}
