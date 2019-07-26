<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTrackRating extends Model
{
    protected $fillable = ['user_id', 'track_id'];
}
