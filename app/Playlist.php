<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $guarded = [];

    public function tracks()
    {
        return $this->belongsToMany(Track::class, 'playlist_has_track');
    }
}
