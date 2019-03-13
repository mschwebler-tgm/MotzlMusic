<?php

namespace App\Http\Controllers\Api;

use App\Daos\UserResourceDao;
use App\DTOs\TrackDTO;
use App\Http\Controllers\Controller;

class PlaylistController extends Controller
{
    public function playlist($id, UserResourceDao $userResourceDao)
    {
        return $userResourceDao->getPlaylist($id);
    }

    public function tracks($id, UserResourceDao $userResourceDao)
    {
        $tracks = $userResourceDao->getPlaylistTracks($id);
        return TrackDTO::toApiResponse($tracks);
    }
}
