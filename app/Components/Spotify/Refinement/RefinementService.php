<?php

namespace App\Components\Spotify\Refinement;

use App\Components\Spotify\SpotifyDao;
use App\Components\Spotify\SpotifyDTO;
use App\Service\Spotify\SpotifyApiService;

class RefinementService
{
    private $spotifyApiService;

    public function __construct(SpotifyApiService $spotifyApiService)
    {
        $this->spotifyApiService = $spotifyApiService;
    }

    public function refineAlbums($albumSpotifyIds)
    {
        $spotifyDao = app(SpotifyDao::class);
        $apiResponse = $this->spotifyApiService->getAlbums($albumSpotifyIds);
        $spotifyAlbums = SpotifyDTO::albumModelsFromResponse($apiResponse->albums);
        foreach ($spotifyAlbums as $spotifyAlbum) {
            $spotifyDao->storeAlbum($spotifyAlbum);
        }
    }
}
