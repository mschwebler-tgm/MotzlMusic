<?php

namespace App\Components\MyLibrary;

use App\Album;
use App\Playlist;
use App\Track;
use App\User;
use Illuminate\Database\Eloquent\Builder;

class MyLibraryDao
{
    /** @var User */
    private $user;

    public function __construct()
    {
        $this->user = apiUser();
    }

    public function getAllPlaylistsExcept(array $except = [])
    {
        return Playlist::where('user_id', $this->user->id)
            ->orderBy('updated_at', 'desc')
            ->whereNotIn('id', $except)
            ->get();
    }

    public function getRecentPlaylists($amount)
    {
        return Playlist::where('user_id', $this->user->id)
            ->orderBy('created_at', 'desc')
            ->limit($amount)
            ->get();
    }

    public function getSpotifyPlaylists()
    {
        return Playlist::where('user_id', $this->user->id)
            ->orderBy('created_at', 'desc')
            ->whereNotNull('spotify_id')
            ->get();
    }

    public function getAllTracks()
    {
        return Track::with('artists', 'album')
            ->where('user_id', $this->user->id)
            ->orderBy('name', 'asc')->get();
    }

    public function getArtistsWithMostTracks()
    {
        $userTrackIds = \DB::query()
            ->select('id')
            ->from('tracks')
            ->where('user_id', $this->user->id)
            ->get()->pluck('id');

        $artists = \DB::query()
            ->selectRaw('count(*) as track_amount, artist_id, artists.*')
            ->from('track_has_artist')
            ->join('artists', 'artist_id', '=', 'artists.id')
            ->whereIn('track_id', $userTrackIds)
            ->groupBy('artist_id')
            ->orderByDesc('track_amount')
            ->limit(10)
            ->get();

        return $artists;
    }

    public function getRecentArtists()
    {
        // TODO: return recent artists instead of random
        return \DB::query()
            ->selectRaw('count(*) as track_amount, artist_id, artists.*')
            ->from('track_has_artist')
            ->join('artists', 'artist_id', '=', 'artists.id')
            ->groupBy('artist_id')
            ->limit(100)
            ->get()->random(10);
    }

    public function getAllAlbums()
    {
        $dbo = \DB::table('tracks');
        $dbo->join('albums', 'albums.id', '=', 'tracks.album_id');
        $dbo->groupBy('albums.id');
        $dbo->where('tracks.user_id', $this->user->id);
        $dbo->select('albums.*');
        $dbo->orderBy('albums.name', 'asc');
        return $dbo->get();
    }

    public function getRecentAlbums()
    {
        // TODO: return recent albums instead of random
        return Album::with('artists')->inRandomOrder()->limit(10)->get();
    }

    public function getAlbums($filterLetter)
    {
        $filterLetter = strtolower($filterLetter);
        $albums = Album::with('artists')
            ->whereHas('tracks', function ($query) {
                /** @var $query Builder */
                $query->where('user_id', $this->user->id);
            })
            ->whereRaw("LOWER(name) LIKE '$filterLetter%'")
            ->distinct()
            ->orderBy('name', 'asc')
            ->get();

        return $albums;
    }
}
