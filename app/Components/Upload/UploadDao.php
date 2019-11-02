<?php

namespace App\Components\Upload;

use App\Components\Spotify\SpotifyDao;
use App\Components\Spotify\Models\Track as SpotifyTrack;
use App\Components\Spotify\DTOs\TrackDTO;
use App\Track;
use App\User;
use App\UserHasTrack;

class UploadDao extends SpotifyDao
{
    public function storeTrack(SpotifyTrack $spotifyTrack, User $user, $albumId = null)
    {
        /** @var Track $track */
        $track = Track::firstOrCreate([
            'spotify_id' => $spotifyTrack->id,
            'name' => $spotifyTrack->name,
            'provider' => 'local',
        ]);
        UserHasTrack::firstOrCreate([
            'track_id' => $track->id,
            'user_id' => $user->id,
            'type' => 'owner',
        ]);
        $track->fill(TrackDTO::spotifyModelToDatabaseArray($spotifyTrack, $albumId))->save();

        return $track;
    }
}
