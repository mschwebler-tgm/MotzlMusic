<?php

namespace App\Components\Spotify\Import\Importers;

use App\DTOs\AlbumDTO;
use Illuminate\Support\Collection;

class SpotifyAlbumImporter extends SpotifyImporter
{
    public function import($spotifyAlbumIds)
    {
        if (count($spotifyAlbumIds) === 0) {
            return;
        }

        $spotifyAlbumsResponse = $this->spotifyApiService->getAlbums($spotifyAlbumIds);
        $spotifyAlbums = AlbumDTO::spotifyToModels($spotifyAlbumsResponse->albums);
        $spotifyAlbums = $this->setAlbumForAlbumTracks($spotifyAlbums);
        $spotifyTracks = $spotifyAlbums->pluck('tracks')->flatten();
        $this->trackImportService->saveTracksForUser($spotifyTracks, $this->user);
    }

    /**
     * @param $spotifyAlbums Collection
     * @return Collection
     */
    private function setAlbumForAlbumTracks(Collection $spotifyAlbums)
    {
        $spotifyAlbums = $spotifyAlbums->map(function ($album) {
            $album->tracks = $album->tracks->map(function ($track) use ($album) {
                $album->tracks = null;
                $track->album = $album;
                return $track;
            });
            return $album;
        });
        return $spotifyAlbums;
    }
}
