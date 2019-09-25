<?php

namespace App\Components\Spotify\Refinement;

use App\Components\Spotify\Api\SpotifyApi;
use App\Components\Spotify\SpotifyDao;
use App\DTOs\AlbumDTO;
use App\DTOs\ArtistDTO;
use App\DTOs\AudioFeatureDTO;

class RefinementService
{
    private $spotifyDao;
    private $spotifyApi;

    public function __construct(SpotifyApi $spotifyApi, SpotifyDao $spotifyDao)
    {
        $this->spotifyApi = $spotifyApi;
        $this->spotifyDao = $spotifyDao;
    }

    public function refineAlbums($albumSpotifyIds)
    {
        $apiResponse = $this->spotifyApi->getAlbums($albumSpotifyIds);
        $spotifyAlbums = AlbumDTO::spotifyToModels($apiResponse->albums);
        foreach ($spotifyAlbums as $spotifyAlbum) {
            $this->spotifyDao->storeAlbum($spotifyAlbum);
        }
    }

    public function refineArtists($artistSpotifyIds)
    {
        $apiResponse = $this->spotifyApi->getArtists($artistSpotifyIds);
        $spotifyArtists = ArtistDTO::spotifyToModels($apiResponse->artists);
        $this->spotifyDao->storeArtists($spotifyArtists);
    }

    public function refineTracks($trackSpotifyIds)
    {
        $apiResponse = $this->spotifyApi->getAudioFeatures($trackSpotifyIds);
        $spotifyAudioFeatures = AudioFeatureDTO::spotifyToModels($apiResponse->audio_features);
        foreach ($spotifyAudioFeatures as $spotifyAudioFeature) {
            $this->spotifyDao->storeAudioFeature($spotifyAudioFeature, current($trackSpotifyIds));
            next($trackSpotifyIds);
        }
    }
}
