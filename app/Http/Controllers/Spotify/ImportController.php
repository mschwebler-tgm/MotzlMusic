<?php

namespace App\Http\Controllers\Spotify;

use App\Components\Spotify\Import\AlbumService;
use App\Components\Spotify\Import\Importers\ProcessSpotifyImportJob;
use App\Components\Spotify\Import\Importers\SpotifyAlbumImporter;
use App\Components\Spotify\Import\Importers\SpotifyPlaylistImporter;
use App\Components\Spotify\Import\Importers\SpotifyTrackImporter;
use App\Components\Spotify\Import\PlaylistTransformer;
use App\Components\Spotify\Import\TrackService;
use App\Daos\UserDao;
use App\Service\Spotify\SpotifyApiService;
use Illuminate\Http\Request;

class ImportController
{
    public function playlists(SpotifyApiService $apiService, PlaylistTransformer $playlistTransformer)
    {
        $playlists = $apiService->getAllMyPlaylists();
        return $playlistTransformer->transform($playlists);
    }

    public function tracks(TrackService $trackService)
    {
        return $trackService->paginate();
    }

    public function albums(AlbumService $albumService)
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
            $request->get('playlists', []),
            apiUser()
        )->onQueue('prio_high');

        $userDao->setSpotifyImportComplete();
    }
}
