<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $guarded = [];
    protected $with = ['rating'];

    public function artists()
    {
        return $this->belongsToMany(Artist::class, 'track_has_artist');
    }

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class, 'playlist_has_track');
    }

    public function owningUsers()
    {
        return $this->belongsToMany(User::class, 'user_has_track')->wherePivot('type', 'owner');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_has_track');
    }

    public function audioFeatures()
    {
        return $this->hasOne(SpotifyAudioFeature::class, 'track_id', 'id');
    }

    public function rating()
    {
        $rating = $this->hasOne(UserTrackRating::class);
        $user = apiUser();
        if ($user) {  // for ide-helper
            $rating->where('user_id', '=', apiUser()->id);
        }

        return $rating;
    }

    /**
     * @param $query Builder
     * @return Builder
     */
    public function scopeOfCurrentUser($query)
    {
        return $query->whereHas('owningUsers', function ($query) {
            $user = apiUser();
            if ($user) {  // for ide-helper
                /** @var $query Builder */
                $query->where('id', apiUser()->id);
            }
        });
    }

    /**
     * @param $query Builder
     * @param $userId int
     * @return Builder
     */
    public function scopeOfUser($query, $userId)
    {
        return $query->whereHas('owningUsers', function ($query) use ($userId) {
            /** @var $query Builder */
            $query->where('id', $userId);
        });
    }
}
