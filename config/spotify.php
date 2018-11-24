<?php

return [

    'auth_path' => 'https://accounts.spotify.com/authorize',
    'auth_redirect' => env('APP_URL') . '/spotify/authorize/landing',
    'client_id' => env('SPOTIFY_CLIENT_ID', 'spotify_client_id_not_set_in_env_file'),
    'client_secret' => env('SPOTIFY_CLIENT_SECRET', 'spotify_client_secret_not_set_in_env_file'),
    'scopes' => [
        'user-library-read',
        'streaming',
        'user-read-email',
        'user-read-private',
        'user-read-birthdate',
        'user-follow-read',
        'user-follow-modify',
        'playlist-read-private',
        'playlist-read-collaborative',
        'user-read-recently-played',
        'user-top-read'
    ],
    'token_url' => 'https://accounts.spotify.com/api/token',

];
