<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model implements HasTracks
{
    protected $guarded = [];
    protected $casts = [
        'is_public' => 'boolean',
    ];

    public function tracks()
    {
        return $this->belongsToMany(Track::class, 'playlist_has_track');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
