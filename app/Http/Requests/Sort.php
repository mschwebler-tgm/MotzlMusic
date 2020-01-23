<?php

namespace App\Http\Requests;

use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;

class Sort
{
    private $identifier;
    private $direction;

    const FIELD_BY_IDENTIFIER = [
        'name' => 'name',
        'duration' => 'duration',
        'album' => 'album_name',
        'artist' => 'artist_name',
        'rating' => 'user_rating',
    ];

    public function __construct($identifier, $direction)
    {
        $this->identifier = $identifier;
        $this->direction = $direction;
    }

    public function apply(Builder $query)
    {
        $this->joinNecessaryField($query);
        $query->orderBy(self::FIELD_BY_IDENTIFIER[$this->identifier], $this->direction);
    }

    private function joinNecessaryField(Builder $query)
    {
        switch ($this->identifier) {
            case 'rating':
                $query
                    ->leftJoin('user_track_ratings', function (JoinClause $query) {
                        $query->on('tracks.id', '=', 'user_track_ratings.track_id');
                        $query->where('user_track_ratings.user_id', '=', apiUser()->id);
                    })
                    ->groupBy('tracks.id')
                    ->addSelect(DB::raw('MAX(user_track_ratings.rating) AS ' . self::FIELD_BY_IDENTIFIER['rating']));
                break;
            case 'artist':
                $query
                    ->leftJoin('track_has_artist', 'track_has_artist.track_id', '=', 'tracks.id')
                    ->leftJoin('artists', 'artists.id', '=', 'track_has_artist.artist_id')
                    ->groupBy('tracks.id')
                    ->addSelect('MAX(artists.name) AS ' . self::FIELD_BY_IDENTIFIER['artist']);
                break;
            case 'album':
                $query->leftJoin('albums', 'albums.id', '=', 'tracks.album_id')
                    ->addSelect('albums.name AS ' . self::FIELD_BY_IDENTIFIER['album']);
        }
    }
}
