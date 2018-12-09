<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
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
}
