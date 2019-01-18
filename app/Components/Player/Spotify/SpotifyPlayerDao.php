<?php

namespace App\Components\Player\Spotify;

use App\Track;

class SpotifyPlayerDao
{
    public function getTrackById($spotifyId)
    {
        return Track::where('spotify_id', '=', $spotifyId)->first();
    }
}