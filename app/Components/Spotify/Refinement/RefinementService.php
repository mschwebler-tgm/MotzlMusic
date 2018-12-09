<?php

namespace App\Components\Spotify\Refinement;

use App\Components\Spotify\SpotifyDao;
use App\Components\Spotify\SpotifyDTO;
use App\Service\Spotify\SpotifyApiService;

class RefinementService
{
    private $spotifyApiService;
    private $spotifyDao;

    public function __construct(SpotifyApiService $spotifyApiService, SpotifyDao $spotifyDao)
    {
        $this->spotifyApiService = $spotifyApiService;
        $this->spotifyDao = $spotifyDao;
    }

    public function refineAlbums($albumSpotifyIds)
    {
        $apiResponse = $this->spotifyApiService->getAlbums($albumSpotifyIds);
        $spotifyAlbums = SpotifyDTO::albumModelsFromResponse($apiResponse->albums);
        foreach ($spotifyAlbums as $spotifyAlbum) {
            $this->spotifyDao->storeAlbum($spotifyAlbum);
        }
    }

    public function refineArtists($artistSpotifyIds)
    {
        $apiResponse = $this->spotifyApiService->getArtists($artistSpotifyIds);
        $spotifyArtists = SpotifyDTO::artistsModelsFromResponse($apiResponse->artists);
        $this->spotifyDao->storeArtists($spotifyArtists);
    }
}
