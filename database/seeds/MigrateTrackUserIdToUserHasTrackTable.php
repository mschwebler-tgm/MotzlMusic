<?php

use App\Track;
use Illuminate\Database\Seeder;
use App\UserHasTrack;

class MigrateTrackUserIdToUserHasTrackTable extends Seeder
{
    public function run()
    {
        $tracks = Track::all();
        /** @var Track $track */
        foreach ($tracks as $track) {
            UserHasTrack::create([
                'user_id' => $track->user_id,
                'track_id' => $track->id,
                'type' => 'owner',
            ]);
        }
    }
}
