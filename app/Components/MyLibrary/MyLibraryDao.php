<?php

namespace App\Components\MyLibrary;

use App\Album;
use App\Playlist;
use App\Track;
use App\User;
use Illuminate\Support\Collection;

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
        return Track::ofCurrentUser()
            ->with('artists', 'album')
            ->orderBy('name', 'asc')->get();
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
}
