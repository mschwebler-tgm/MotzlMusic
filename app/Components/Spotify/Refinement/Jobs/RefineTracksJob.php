<?php

namespace App\Components\Spotify\Refinement\Jobs;

use App\Components\Spotify\Refinement\RefinementService;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RefineTracksJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $trackSpotifyIds;

    public function __construct($trackSpotifyIds)
    {
        $this->trackSpotifyIds = $trackSpotifyIds;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /** @var RefinementService $refinementService */
        $refinementService = app(RefinementService::class);
        $refinementService->refineTracks($this->trackSpotifyIds);
    }
}
