<?php

namespace App\Http\Controllers\Player;

use App\Components\Player\Spotify\Requests\SpotifyPlayTrackRequest;
use App\Components\Player\Spotify\SpotifyPlayerService;
use App\Http\Controllers\Controller;

class SpotifyPlayerController extends Controller
{
    public function playTrack(SpotifyPlayTrackRequest $playRequest, SpotifyPlayerService $playerService)
    {
        $playerService->playTrack($playRequest->getTrackId(), $playRequest->getDeviceId());
    }
}
