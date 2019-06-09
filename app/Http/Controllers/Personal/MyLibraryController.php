<?php

namespace App\Http\Controllers\Personal;

use App\Components\MyLibrary\AlbumByLetterOccurrence;
use App\Components\MyLibrary\AlbumDao;
use App\Components\MyLibrary\MyLibraryDao;
use App\DTOs\AlbumDTO;
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

    public function getArtistsByFirstLetter()
    {
        return $this->libraryDao->getRecentArtists();
    }

    public function getAlbums(AlbumDao $albumDao)
    {
        return $albumDao->getAlbums();
    }

    public function getAlbumsByFirstLetter(AlbumDao $albumDao)
    {
        $albumsByLetter = $albumDao->getAlbumsByFirstLetter();
        $albumsByLetter->map(function (AlbumByLetterOccurrence $albumByLetter) {
            $albumByLetter->setAlbums(AlbumDTO::toApiResponse($albumByLetter->getAlbums()));
        });

        return $albumsByLetter;
    }
}
