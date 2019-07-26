<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpotifyAudioFeature extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    protected $casts = [
        'acousticness' => 'double',
        'danceability' => 'double',
        'energy' => 'double',
        'instrumentalness' => 'double',
        'key' => 'double',
        'liveness' => 'double',
        'loudness' => 'double',
        'mode' => 'double',
        'speechiness' => 'double',
        'tempo' => 'double',
        'valence' => 'double',
    ];

    public function track()
    {
        return $this->belongsTo(Track::class);
    }
}
