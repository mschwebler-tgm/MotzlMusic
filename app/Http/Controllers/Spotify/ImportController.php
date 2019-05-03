<?php

namespace App\Http\Controllers\Spotify;

use App\Components\Spotify\Import\Importers\ProcessSpotifyImportJob;
use App\Components\Spotify\Import\Importers\SpotifyAlbumImporter;
use App\Components\Spotify\Import\Importers\SpotifyPlaylistImporter;
use App\Components\Spotify\Import\Importers\SpotifyTrackImporter;
use App\Components\Spotify\Import\SpotifyAlbumService;
use App\Components\Spotify\Import\SpotifyPlaylistService;
use App\Components\Spotify\Import\SpotifyTrackService;
use App\Daos\UserDao;
use Illuminate\Http\Request;

class ImportController
{
    public function playlists(SpotifyPlaylistService $playlistService)
    {
        return $playlistService->paginate();
    }

    public function tracks(SpotifyTrackService $trackService)
    {
        return $trackService->paginate();
    }

    public function albums(SpotifyAlbumService $albumService)
    {
        return $albumService->paginate();
    }

    public function import(Request $request, UserDao $userDao)
    {
        ProcessSpotifyImportJob::dispatch(
            app(SpotifyTrackImporter::class),
            $request->get('importSavedTracks', false),
            apiUser()
        )->onQueue('prio_high');
        ProcessSpotifyImportJob::dispatch(
            app(SpotifyAlbumImporter::class),
            $request->get('albums', []),
            apiUser()
        )->onQueue('prio_high');
        ProcessSpotifyImportJob::dispatch(
            app(SpotifyPlaylistImporter::class),
            $request->get('playlistIds', []),
            apiUser()
        )->onQueue('prio_high');

        $userDao->setSpotifyImportComplete();
    }
}
