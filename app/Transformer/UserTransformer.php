<?php

namespace App\Transformer;

class UserTransformer
{
    public function transform($user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'is_spotify' => (bool) $user->spotify_id,
            'spotify_import_complete' => $user->spotify_import_complete,
            'birthdate' => $user->birthdate
        ];
    }
}
