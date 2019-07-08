<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $guarded = [];

    public function artists()
    {
        return $this->belongsToMany(Artist::class, 'track_has_artist');
    }

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function owningUsers()
    {
        return $this->belongsToMany(User::class, 'user_has_track')->wherePivot('type', 'owner');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_has_track');
    }

    public function audioFeatures()
    {
        return $this->hasOne(SpotifyAudioFeature::class, 'track_id', 'id');
    }

    /**
     * @param $query Builder
     * @return Builder
     */
    public function scopeOfCurrentUser($query)
    {
        return $query->whereHas('owningUsers', function ($query) {
            /** @var $query Builder */
            $query->where('id', apiUser()->id);
        });
    }

    /**
     * @param $query Builder
     * @param $userId int
     * @return Builder
     */
    public function scopeOfUser($query, $userId)
    {
        return $query->whereHas('owningUsers', function ($query) use ($userId) {
            /** @var $query Builder */
            $query->where('id', $userId);
        });
    }
}
