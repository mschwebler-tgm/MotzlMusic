<?php

namespace App\Transformer;

use App\User;

class UserTransformer
{
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'is_spotify' => (bool) $user->spotify_id,
            'spotify_import_complete' => $user->spotify_import_complete,
            'birthdate' => $user->birthdate,
            'profile_image' => $user->profile_image
        ];
    }
}
