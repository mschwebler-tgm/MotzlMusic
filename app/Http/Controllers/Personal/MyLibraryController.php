<?php

namespace App\Http\Controllers\Personal;

use App\Components\MyLibrary\AlbumDao;
use App\Components\MyLibrary\ArtistDao;
use App\Components\MyLibrary\MyLibraryDao;
use App\Http\Controllers\Controller;
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

    public function getArtistsByFirstLetter(ArtistDao $artistDao)
    {
        return $artistDao->getItemsByFirstLetter();
    }

    public function getArtistsSingleTracks(ArtistDao $artistDao)
    {
        return $artistDao->getSingleTracksIds();
    }

    public function getArtistTrackIds($id, ArtistDao $artistDao)
    {
        return $artistDao->getTracksForArtist($id)->pluck('id');
    }

    public function getAlbums(AlbumDao $albumDao)
    {
        return $albumDao->getAlbums();
    }

    public function getAlbumsByFirstLetter(AlbumDao $albumDao)
    {
        return $albumDao->getItemsByFirstLetter();
    }

    public function getAlbumsSingleTracks(AlbumDao $albumDao)
    {
        return $albumDao->getSingleTrackIds();
    }

    public function addTrack($id)
    {
        $this->libraryDao->addTrack($id);
    }

    public function removeTrack($id)
    {
        $this->libraryDao->removeTrack($id);
    }
}
