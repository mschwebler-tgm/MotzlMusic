<?php

namespace App\Service\GenericDaos;

use App\Http\Requests\Sort;
use App\Service\GenericDaos\Exceptions\TrackNotFoundException;
use App\Track;
use App\User;
use App\UserTrackRating;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Collection;

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

    public function getSorted(array $ids, Collection $sorting)
    {
        $query = Track::query()
            ->whereIn('tracks.id', $ids)
            ->select('tracks.*');

        /** @var Sort $sort */
        foreach ($sorting as $sort) {
            $sort->apply($query);
        }

        return $query->get();
    }

    public function getForUser($id, User $user = null)
    {
        return $user
            ->tracks()
            ->where('id', '=', $id)
            ->findOrFail($id);
    }

    public function tracks(array $ids)
    {
        return Track::whereIn('id', $ids)->get();
    }

    public function all()
    {
        return Track::with('artists', 'album', 'audioFeatures')
            ->orderBy('name', 'asc')
            ->get();
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
