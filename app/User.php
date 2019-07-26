<?php

namespace App;

use App\Components\UserSettings\UserSettings;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 * @package App
 * @property UserSettings $settings
 */
class User extends Authenticatable implements HasTracks
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'spotify_id',
        'birthdate',
        'spotify_access_token',
        'spotify_refresh_token',
        'spotify_token_expire',
        'email_verified_at',
        'profile_image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'spotify_access_token',
        'spotify_refresh_token'
    ];

    protected $casts = [
        'spotify_import_complete' => 'boolean',
    ];

    public function getMp3StoragePath()
    {
        return snake_case("mp3s/{$this->name}");
    }

    public function tracks()
    {
        return $this->belongsToMany(Track::class, 'user_has_track');
    }

    public function setSettingsAttribute(UserSettings $settings)
    {
        $this->attributes['settings'] = $settings->toJson();
    }

    public function getSettingsAttribute()
    {
        return UserSettings::fromJson($this->attributes['settings']);
    }
}
