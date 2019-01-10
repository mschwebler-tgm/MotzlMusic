<?php

namespace App\Http\Controllers\Personal;

use App\Components\MyLibrary\MyLibraryDao;
use App\DTOs\TrackDTO;
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
        return TrackDTO::toApiResponse($this->libraryDao->getAllTracks());
    }

    public function myTopArtists()
    {
        return $this->libraryDao->getArtistsWithMostTracks();
    }

    public function myRecentArtists()
    {
        return $this->libraryDao->getRecentArtists();
    }

    public function myAlbums()
    {
        return $this->libraryDao->getAllAlbums();
    }
}
