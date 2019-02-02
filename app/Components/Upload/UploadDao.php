<?php

namespace App\Components\Upload;

use App\Components\Spotify\SpotifyDao;
use App\Components\Spotify\Models\Track as SpotifyTrack;
use App\DTOs\TrackDTO;
use App\Track;
use App\User;

class UploadDao extends SpotifyDao
{
    public function storeTrack(SpotifyTrack $spotifyTrack, User $user, $albumId = null)
    {
        /** @var Track $track */
        $track = Track::firstOrCreate([
            'spotify_id' => $spotifyTrack->id,
            'name' => $spotifyTrack->name,
            'user_id' => $user->id,
            'type' => 'local',
        ]);
        $track->fill(TrackDTO::spotifyModelToDatabaseArray($spotifyTrack, $user, $albumId))->save();

        return $track;
    }
}
