<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpotifyAudioFeature extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function track()
    {
        return $this->belongsTo(Track::class);
    }
}
