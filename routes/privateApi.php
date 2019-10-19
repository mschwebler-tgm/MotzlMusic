<?php

use Illuminate\Support\Facades\Route;

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
    Route::put('subContent', 'SubContentController@updateSubContent');
    Route::get('/subContent/available', 'SubContentController@availableContent');
});

Route::prefix('settings')->namespace('\App\Components\UserSettings\Http')->group(function () {
    Route::post('notifications', 'SettingsController@storeNotificationSettings');
    Route::post('privacy', 'SettingsController@storePrivacySettings');
    Route::post('nickname', 'SettingsController@storeUserNickname');
    Route::post('appearance', 'SettingsController@storeAppearanceSettings');
});

Route::prefix('player')->namespace('Player')->group(function () {
    Route::put('/spotify/playTrack', 'SpotifyPlayerController@playTrack');
});

Route::namespace('Api')->group(function () {
    Route::get('/playlist/{id}', 'PlaylistController@playlist');
    Route::get('/playlist/{id}/tracks', 'PlaylistController@tracks');
    Route::get('/track/{id}/audio-features', 'TrackController@audioFeatures');
    Route::put('/track/{id}/rate', 'TrackController@rateTrack');
    Route::get('/track/{id}', 'TrackController@getDetails');
});

Route::post('/uploadTrack', 'UploadController@uploadTrack');
