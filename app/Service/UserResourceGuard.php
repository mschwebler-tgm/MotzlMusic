<?php

namespace App\Service;

use App\Playlist;
use App\Service\UserResourceGuards\PlaylistGuard;
use App\Service\UserResourceGuards\UserResourceGuardInterface;
use Illuminate\Database\Eloquent\Model;

class UserResourceGuard
{
    const GUARD_BY_MODEL = [
        Playlist::class => PlaylistGuard::class
    ];

    /**
     * @param Model $resource
     * @return Model
     */
    public static function getResource($resource)
    {
        if (!$resource) {
            abort(404, 'We\'re sorry, we could not find the resource you requested.');
        }

        $guard = self::getResourceGuard($resource);
        if (!$guard) {
            return $resource;
        }

        return $guard->get($resource);
    }

    /**
     * @param Model $resource
     * @return UserResourceGuardInterface|null
     */
    private static function getResourceGuard(Model $resource)
    {
        if (array_key_exists(get_class($resource), self::GUARD_BY_MODEL)) {
            return app(self::GUARD_BY_MODEL[get_class($resource)]);
        }

        return null;
    }
}
