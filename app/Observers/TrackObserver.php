<?php

namespace App\Observers;

use App\Components\Deezer\DownloadJob;
use App\Track;

class TrackObserver
{
    public function updated(Track $track)
    {
        if (config('app.download_tracks') && $track->wasChanged('isrc')) {
            \Log::info('dispatch Job');
            dispatch(new DownloadJob($track->id));
        }
    }
}
