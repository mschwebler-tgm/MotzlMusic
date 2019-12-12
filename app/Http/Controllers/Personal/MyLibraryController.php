<?php

namespace App\Http\Controllers\Personal;

use App\Components\MyLibrary\MyLibraryDao;
use App\Http\Controllers\Controller;
use App\Service\GenericDaos\AlbumDao;
use App\Service\GenericDaos\ArtistDao;
use App\Service\GenericDaos\PlaylistDao;
use App\Service\GenericDaos\TrackDao;
use App\Transformer\PlaylistTransformer;
use App\Transformer\TrackTransformer;

class MyLibraryController extends Controller
{
    private $libraryDao;

    public function __construct(MyLibraryDao $libraryDao)
    {
        $this->libraryDao = $libraryDao;
    }

    // Playlists

    public function myPlaylists(PlaylistDao $playlistDao, PlaylistTransformer $transformer)
    {
        $recent = $playlistDao->getRecentPlaylists(3);
        $spotify = $playlistDao->getSpotifyPlaylists();
        $remaining = $playlistDao->getAllPlaylistsExcept($recent->pluck('id')->merge($spotify->pluck('id'))->toArray());
        return [
            'recent' => $transformer->transform($recent),
            'spotify' => $transformer->transform($spotify),
            'ungrouped' => $transformer->transform($remaining),
        ];
    }

    // Tracks

    public function myTracks(TrackDao $trackDao, TrackTransformer $transformer)
    {
        return $transformer->transform($trackDao->all());
    }

    public function addTrack($id)
    {
        $this->libraryDao->addTrack($id);
    }

    public function removeTrack($id)
    {
        $this->libraryDao->removeTrack($id);
    }

    // Artists

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
        return $artistDao->tracksForArtist($id)->pluck('id');
    }

    public function getArtistAlbumIds($id, ArtistDao $artistDao)
    {
        return $artistDao->albumsForArtist($id)->pluck('id');
    }

    // Albums

    public function getAlbumsByFirstLetter(AlbumDao $albumDao)
    {
        return $albumDao->getItemsByFirstLetter();
    }

    public function getAlbumsSingleTracks(AlbumDao $albumDao)
    {
        return $albumDao->getSingleTrackIds();
    }

    public function getAlbumTrackIds($id, AlbumDao $albumDao)
    {
        return $albumDao->tracksForAlbum($id)->pluck('id');
    }
}
