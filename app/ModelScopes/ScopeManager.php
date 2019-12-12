<?php

namespace App\ModelScopes;

use App\Album;
use App\Artist;
use App\Playlist;
use App\Track;

class ScopeManager
{
    public static function registerCurrentUserScopes()
    {
        Track::addGlobalScope(new TracksCurrentUserScope());
        Album::addGlobalScope(new AlbumsCurrentUserScope());
        Artist::addGlobalScope(new ArtistsCurrentUserScope());
        Playlist::addGlobalScope(new PlaylistsCurrentUserScope());
    }
}
