<?php

namespace App\Service\GenericDaos;

use App\Service\GenericDaos\Exceptions\TrackNotFoundException;
use App\Track;
use App\UserTrackRating;

class TrackDao
{
    /**
     * @param $id
     * @return Track
     * @throws TrackNotFoundException
     */
    public function get($id)
    {
        $track = Track::find($id);
        if (!$track) {
            throw new TrackNotFoundException("ID: $id");
        }

        return $track;
    }

    public function trackDetails($id)
    {
        return Track::with('artists', 'album')->find($id);
    }

    public function updateLocalPath(Track $track, $path)
    {
        if (!file_exists(storage_path("app/$path"))) {
            return false;
        }

        $track->local_path = $path;
        return $track->save();
    }

    public function setUserRating($trackId, $userId, $stars)
    {
        /** @var UserTrackRating $rating */
        $rating = UserTrackRating::where('user_id', '=', $userId)
            ->where('track_id', '=', $trackId)
            ->first();
        if (!$rating) {
            $rating = new UserTrackRating();
            $rating->track_id = $trackId;
            $rating->user_id = $userId;
        }
        $rating->rating = $stars;
        $rating->save();
    }
}
