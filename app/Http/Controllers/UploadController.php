<?php

namespace App\Http\Controllers;

use App\Components\Spotify\Import\TrackImportService;
use App\Components\Upload\SpotifyMatcher;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function uploadTrack(Request $request, SpotifyMatcher $spotifyMatcher, TrackImportService $trackImportService)
    {
        $mp3File = $request->file('track');
        $trackName = pathinfo($mp3File->getClientOriginalName(), PATHINFO_FILENAME);
        $spotifyTrack = $spotifyMatcher->getEstimatedSpotifyMatch($trackName);
        if ($spotifyTrack) {
            $tracks = $trackImportService->saveTracksForUser(collect([$spotifyTrack]), apiUser());
            $track = $tracks->first();
            dd($track);
        }
        dd($spotifyTrack);

        return response(null, 200);
    }
}
