<?php

namespace App\Http\Controllers\Api;

use App\Daos\UserResourceDao;
use App\Http\Controllers\Controller;

class PlaylistController extends Controller
{
    public function playlist($id, UserResourceDao $userResourceDao)
    {
        return $userResourceDao->getPlaylist($id);
    }
}
