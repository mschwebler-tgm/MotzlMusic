<?php

namespace App\Http\Middleware;

use App\Album;
use App\Artist;
use App\ModelScopes\AlbumsCurrentUserScope;
use App\ModelScopes\ArtistsCurrentUserScope;
use App\ModelScopes\PlaylistsCurrentUserScope;
use App\ModelScopes\TracksCurrentUserScope;
use App\Playlist;
use App\Track;
use Closure;

class PrivateLibrary
{
    public function handle($request, Closure $next)
    {
        Track::addGlobalScope(new TracksCurrentUserScope());
        Album::addGlobalScope(new AlbumsCurrentUserScope());
        Artist::addGlobalScope(new ArtistsCurrentUserScope());
        Playlist::addGlobalScope(new PlaylistsCurrentUserScope());

        return $next($request);
    }
}
