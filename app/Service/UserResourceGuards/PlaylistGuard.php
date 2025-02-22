<?php

namespace App\Service\UserResourceGuards;

use App\Playlist;
use Illuminate\Database\Eloquent\Model;

class PlaylistGuard implements UserResourceGuardInterface
{
    /**
     * @param Playlist|Model $resource
     * @return Playlist|Model
     */
    public function get(Model $resource)
    {
        if ($resource->user->id !== apiUser()->id) {
            abort(403, 'We\'re sorry, you don\'t have access to the resource you requested.');
        }

        return $resource;
    }
}
