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
    Route::get('topArtists', 'MyLibraryController@myTopArtists');
    Route::get('recentArtists', 'MyLibraryController@myRecentArtists');
    Route::get('recentAlbums', 'MyLibraryController@myRecentAlbums');
});

Route::prefix('player')->namespace('Player')->group(function () {
    Route::put('/spotify/playTrack', 'SpotifyPlayerController@playTrack');
});

Route::namespace('Api')->group(function () {
    Route::get('/playlist/{id}', 'PlaylistController@playlist');
    Route::get('/playlist/{id}/tracks', 'PlaylistController@tracks');
});

Route::post('/uploadTrack', 'UploadController@uploadTrack');