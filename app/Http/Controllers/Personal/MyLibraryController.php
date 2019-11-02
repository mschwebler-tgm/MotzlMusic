<?php

namespace App\Http\Controllers\Personal;

use App\Album;
use App\Artist;
use App\Components\MyLibrary\AlbumDao;
use App\Components\MyLibrary\ArtistDao;
use App\Components\MyLibrary\MyLibraryDao;
use App\DTOs\PlaylistDTO;
use App\Http\Controllers\Controller;
use App\Transformer\AlbumTransformer;
use App\Transformer\ArtistTransformer;
use App\Transformer\PlaylistTransformer;
use App\Transformer\TrackTransformer;

class MyLibraryController extends Controller
{
    private $libraryDao;

    public function __construct(MyLibraryDao $libraryDao)
    {
        $this->libraryDao = $libraryDao;
    }

    public function myPlaylists(PlaylistTransformer $transformer)
    {
        $recent = $this->libraryDao->getRecentPlaylists(3);
        $spotify = $this->libraryDao->getSpotifyPlaylists();
        $remaining = $this->libraryDao->getAllPlaylistsExcept($recent->pluck('id')->merge($spotify->pluck('id'))->toArray());
        return [
            'recent' => $transformer->transform($recent),
            'spotify' => $transformer->transform($spotify),
            'ungrouped' => $transformer->transform($remaining),
        ];
    }

    public function myTracks(TrackTransformer $transformer)
    {
        return $transformer->transform($this->libraryDao->getAllTracks());
    }

    public function getArtistsByFirstLetter(ArtistDao $artistDao, ArtistTransformer $transformer)
    {
        $artistsByLetter = $artistDao->getItemsByFirstLetter();
        foreach ($artistsByLetter as &$artistByLetter) {
            $transformedItems = $artistByLetter->getItems()->map(function (Artist $artist) use ($transformer) {
                return $transformer->transform($artist);
            });
            $artistByLetter->setItems($transformedItems);
        }
        return $artistsByLetter;
    }

    public function getAlbums(AlbumDao $albumDao)
    {
        return $albumDao->getAlbums();
    }

    public function getAlbumsByFirstLetter(AlbumDao $albumDao, AlbumTransformer $transformer)
    {
        $albumsByLetter = $albumDao->getItemsByFirstLetter();
        foreach ($albumsByLetter as &$albumByLetter) {
            $transformedItems = $albumByLetter->getItems()->map(function (Album $album) use ($transformer) {
                return $transformer->transform($album);
            });
            $albumByLetter->setItems($transformedItems);
        }

        return $albumsByLetter;
    }

    public function addTrack($id)
    {
        return $this->libraryDao->addTrack($id);
    }

    public function removeTrack($id)
    {
        $this->libraryDao->removeTrack($id);
    }
}
