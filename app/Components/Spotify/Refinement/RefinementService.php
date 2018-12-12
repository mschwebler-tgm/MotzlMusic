<?php

namespace App\Components\Spotify\Refinement;

use App\Components\Spotify\SpotifyDao;
use App\Components\Spotify\SpotifyDTO;
use App\Service\Spotify\SpotifyApiService;
use App\User;

class RefinementService
{
    private $spotifyApiService;
    private $spotifyDao;

    public function __construct(SpotifyApiService $spotifyApiService, SpotifyDao $spotifyDao)
    {
        $this->spotifyApiService = $spotifyApiService;
        $this->spotifyDao = $spotifyDao;
    }

    public function setSpotifyApiUser(User $user)
    {
        $this->spotifyApiService->setApiUser($user);
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
        $spotifyArtists = SpotifyDTO::artistModelsFromResponse($apiResponse->artists);
        $this->spotifyDao->storeArtists($spotifyArtists);
    }

    public function refineTracks($trackSpotifyIds)
    {
        $apiResponse = $this->spotifyApiService->getAudioFeatures($trackSpotifyIds);
        $spotifyAudioFeatures = SpotifyDTO::audioFeatureModelsFromResponse($apiResponse->audio_features);
        foreach ($spotifyAudioFeatures as $spotifyAudioFeature) {
            $this->spotifyDao->storeAudioFeature($spotifyAudioFeature, current($trackSpotifyIds));
            next($trackSpotifyIds);
        }
    }
}
