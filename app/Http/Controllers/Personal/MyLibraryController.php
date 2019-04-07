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
        $recent = $this->libraryDao->getRecentPlaylists(3);
        $spotify = $this->libraryDao->getSpotifyPlaylists();
        $remaining = $this->libraryDao->getAllPlaylistsExcept($recent->pluck('id')->merge($spotify->pluck('id'))->toArray());
        return [
            'recent' => $recent,
            'spotify' => $spotify,
            'ungrouped' => $remaining,
        ];
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

    public function myRecentAlbums()
    {
        return $this->libraryDao->getRecentAlbums();
    }
}
