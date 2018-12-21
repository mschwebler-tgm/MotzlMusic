<?php

namespace App\Components\MyLibrary;

use App\Playlist;
use App\Track;

class MyLibraryDao
{
    public function getAllPlaylists()
    {
        return Playlist::where('user_id', apiUser()->id)->orderBy('updated_at', 'desc')->get();
    }

    public function getAllTracks()
    {
        return Track::with('artists', 'album')->where('user_id', apiUser()->id)->limit(100)->get();
    }

    public function getAllArtists()
    {
        $dbo = \DB::table('tracks');
        $dbo->join('track_has_artist', 'tracks.id', '=', 'track_has_artist.track_id');
        $dbo->join('artists', 'artists.id', '=', 'track_has_artist.artist_id');
        $dbo->groupBy('artists.id');
        $dbo->where('tracks.user_id', apiUser()->id);
        $dbo->select('artists.*');
        $dbo->orderBy('artists.name', 'asc');
        return $dbo->get();
    }

    public function getAllAlbums()
    {
        $dbo = \DB::table('tracks');
        $dbo->join('albums', 'albums.id', '=', 'tracks.album_id');
        $dbo->groupBy('albums.id');
        $dbo->where('tracks.user_id', apiUser()->id);
        $dbo->select('albums.*');
        $dbo->orderBy('albums.name', 'asc');
        return $dbo->get();
    }
}
