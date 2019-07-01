<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
});

# Spotify
Route::prefix('spotify')->namespace('Spotify')->group(function () {
    Route::get('/playlists/my', 'ImportController@playlists');
    Route::get('/tracks/my', 'ImportController@tracks');
    Route::get('/albums/my', 'ImportController@albums');
    Route::post('/import', 'ImportController@import');
    Route::get('/access', 'AuthController@getAccessToken');
});

Route::prefix('my')->namespace('Personal')->group(function () {
    Route::get('playlists', 'MyLibraryController@myPlaylists');
    Route::get('tracks', 'MyLibraryController@myTracks');
    Route::delete('tracks/{id}', 'MyLibraryController@removeTrack');
    Route::put('tracks/{id}', 'MyLibraryController@addTrack');
    Route::get('artists/byFirstLetter', 'MyLibraryController@getArtistsByFirstLetter');
    Route::get('albums/byFirstLetter', 'MyLibraryController@getAlbumsByFirstLetter');
    Route::get('albums', 'MyLibraryController@getAlbums');
});

Route::prefix('player')->namespace('Player')->group(function () {
    Route::put('/spotify/playTrack', 'SpotifyPlayerController@playTrack');
});

Route::namespace('Api')->group(function () {
    Route::get('/playlist/{id}', 'PlaylistController@playlist');
    Route::get('/playlist/{id}/tracks', 'PlaylistController@tracks');
    Route::get('/track/{id}/audio-features', 'TrackController@audioFeatures');
    Route::get('/track/{id}', 'TrackController@getDetails');
});

Route::post('/uploadTrack', 'UploadController@uploadTrack');
