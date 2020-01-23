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
        $query = Track::query()->whereIn('tracks.id', $ids);
        $this->joinSortableColumns($query);

        /** @var Sort $sort */
        foreach ($sorting as $sort) {
            $sort->apply($query);
        }

        return $query->get();
    }

    private function joinSortableColumns(Builder $query)
    {
        $query
            ->leftJoin('user_track_ratings', function (JoinClause $query) {
                $query->on('tracks.id', '=', 'user_track_ratings.track_id');
                $query->where('user_track_ratings.user_id', '=', apiUser()->id);
            })
            ->leftJoin('albums', 'albums.id', '=', 'tracks.album_id')
            ->leftJoin('track_has_artist', 'track_has_artist.track_id', '=', 'tracks.id')
            ->leftJoin('artists', 'artists.id', '=', 'track_has_artist.artist_id')
            ->groupBy('tracks.id')
            ->selectRaw('tracks.*, MAX(user_track_ratings.rating) as user_rating, albums.name as album_name, MAX(artists.name) as artist_name');
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
