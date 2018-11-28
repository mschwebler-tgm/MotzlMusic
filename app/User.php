<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'spotify_id', 'birthdate', 'spotify_access_token', 'spotify_refresh_token', 'spotify_token_expire', 'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'spotify_id', 'spotify_access_token', 'spotify_refresh_token'
    ];

    protected $casts = [
        'spotify_import_complete' => 'boolean'
    ];
}
