<?php

return [

    'auth_path' => 'https://accounts.spotify.com/authorize',
    'client_id' => env('SPOTIFY_CLIENT_ID'),
    'client_secret' => env('SPOTIFY_CLIENT_SECRET'),
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
    ]

];
