<?php

namespace App\Http\Controllers\Api;

use App\Daos\UserResourceDao;
use App\Http\Controllers\Controller;
use App\Transformer\PlaylistTransformer;
use App\Transformer\TrackTransformer;

class PlaylistController extends Controller
{
    public function playlist($id, UserResourceDao $userResourceDao, PlaylistTransformer $transformer)
    {
        return $transformer->transform($userResourceDao->getPlaylist($id));
    }

    public function tracks($id, UserResourceDao $userResourceDao, TrackTransformer $transformer)
    {
        $tracks = $userResourceDao->getPlaylistTracks($id);
        return $transformer->transform($tracks);
    }
}
