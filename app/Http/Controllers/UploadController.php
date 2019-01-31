<?php

namespace App\Http\Controllers;

use App\Components\Upload\SpotifyMatcher;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function uploadTrack(Request $request, SpotifyMatcher $spotifyMatcher)
    {
        $mp3File = $request->file('track');
        $trackName = pathinfo($mp3File->getClientOriginalName(), PATHINFO_FILENAME);
        $spotifyMatcher->getEstimatedSpotifyMatch($trackName);
        dd($mp3File);
//        $a = $mp3File->store(apiUser()->mp3StoragePath());
        return response(null, 200);
    }
}
