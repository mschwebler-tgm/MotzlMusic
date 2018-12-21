<?php

namespace App;

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
}
