<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserHasTrack extends Model
{
    protected $table = 'user_has_track';
    public $timestamps = false;
    protected $guarded = [];
}
