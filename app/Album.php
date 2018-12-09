<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $guarded = [];

    public function artists()
    {
        return $this->belongsToMany(Artist::class, 'album_has_artist');
    }
}
