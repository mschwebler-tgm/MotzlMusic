<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

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
        'password', 'remember_token', 'spotify_access_token', 'spotify_refresh_token'
    ];

    protected $casts = [
        'spotify_import_complete' => 'boolean'
    ];

    public function getMp3StoragePath()
    {
        return snake_case("mp3s/{$this->name}");
    }

    public function tracks()
    {
        return $this->belongsToMany(Track::class, 'user_has_track');
    }
}
