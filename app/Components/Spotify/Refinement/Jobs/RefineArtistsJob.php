<?php

namespace App\Components\Spotify\Refinement\Jobs;

use App\Components\Spotify\Refinement\RefinementService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RefineArtistsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $artistSpotifyIds;

    public function __construct($artistSpotifyIds)
    {
        $this->artistSpotifyIds = $artistSpotifyIds;
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
        $refinementService->refineArtists($this->artistSpotifyIds);
    }
}
