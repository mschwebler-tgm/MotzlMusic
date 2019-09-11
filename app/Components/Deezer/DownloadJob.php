<?php

namespace App\Components\Deezer;

use App\Service\GenericDaos\Exceptions\TrackNotFoundException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class DownloadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    private $trackId;

    public function __construct($trackId)
    {
        $this->trackId = $trackId;
    }

    public function handle()
    {
        $downloader = app(DeezerDownloader::class);
        try {
            $downloader->downloadTrack($this->trackId);
        } catch (TrackNotFoundException $exception) {
            \Log::info("Failed to download track. Track with id '$this->trackId' not found");
        }
    }
}
