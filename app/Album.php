<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Album extends Model implements HasTracks
{
    protected $guarded = [];

    public function artists()
    {
        return $this->belongsToMany(Artist::class, 'album_has_artist');
    }

    public function tracks()
    {
        return $this->hasMany(Track::class);
    }

    /**
     * @param $query Builder
     * @param $userId int
     * @return Builder
     */
    public function scopeOfUser($query, $userId)
    {
        return $query->whereHas('tracks', function ($query) use ($userId) {
            /** @var $query Builder */
            $query->whereHas('owningUsers', function ($query) use ($userId) {
                /** @var $query Builder */
                $query->where('id', $userId);
            });
        });
    }

    /**
     * @param $query Builder
     * @return Builder
     */
    public function scopeOfCurrentUser($query)
    {
        return $query->whereHas('tracks', function ($query) {
            /** @var $query Builder */
            $query->whereHas('owningUsers', function ($query) {
                /** @var $query Builder */
                $query->where('id', apiUser()->id);
            });
        });
    }
}
