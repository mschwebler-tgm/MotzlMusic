<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model implements HasTracks
{
    protected $guarded = [];

    public function tracks()
    {
        return $this->belongsToMany(Track::class, 'track_has_artist');
    }

    public function albums()
    {
        return $this->belongsToMany(Album::class, 'album_has_artist');
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
                $query->where('id', '=', apiUser()->id);
            });
        });
    }
}
