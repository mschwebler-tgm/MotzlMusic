<?php

namespace App\Components\Spotify\DTOs;

use App\Components\Spotify\Models\BaseModel as SpotifyBaseModel;
use Illuminate\Support\Collection;

interface SpotifyDTO
{
    /**
     * @param $spotifyResponse
     * @return Collection
     */
    public static function spotifyToModels($spotifyResponse);

    /**
     * @param $spotifyResponse
     * @return SpotifyBaseModel
     */
    public static function spotifyToModel($spotifyResponse);
}
