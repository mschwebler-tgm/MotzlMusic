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

Route::prefix('my')->middleware('library.private')->namespace('Personal')->group(function () {
    Route::get('playlists', 'MyLibraryController@myPlaylists')->name('getMyPlaylists');
    Route::get('tracks', 'MyLibraryController@myTracks')->name('getMyTracks');
    Route::delete('tracks/{id}', 'MyLibraryController@removeTrack');
    Route::put('tracks/{id}', 'MyLibraryController@addTrack');
    Route::get('artists/byFirstLetter', 'MyLibraryController@getArtistsByFirstLetter')->name('getArtistsByLetter');
    Route::get('artists/singleTracks', 'MyLibraryController@getArtistsSingleTracks')->name('getArtistsSingleTracks');
    Route::get('artist/{id}/tracksIds', 'MyLibraryController@getArtistTrackIds')->name('getMyArtistTrackIds');
    Route::get('albums/byFirstLetter', 'MyLibraryController@getAlbumsByFirstLetter')->name('getAlbumsByLetter');
    Route::get('albums/singleTracks', 'MyLibraryController@getAlbumsSingleTracks')->name('getAlbumsSingleTracks');
    Route::get('albums', 'MyLibraryController@getAlbums')->name('getMyAlbums');
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
    Route::get('/playlist/{id}', 'PlaylistController@playlist')->name('getPlaylist');
    Route::get('/playlist/{id}/tracks', 'PlaylistController@tracks')->name('getPlaylistTracks');
    Route::get('/playlist/{id}/audio-features', 'PlaylistController@audioFeatures')->name('getPlaylistAudioFeatures');
    Route::get('/track/{id}', 'TrackController@get')->name('getTrack');
    Route::put('/track/{id}/rate', 'TrackController@rateTrack');
    Route::get('/track/{id}/audio-features', 'TrackController@audioFeatures')->name('getTrackAudioFeatures');
    Route::get('/tracks/{ids}', 'TrackController@tracks')->name('getTracks');
    Route::get('/artist/{id}', 'ArtistController@artist')->name('getArtist');
    Route::get('/artist/{id}/tracks', 'ArtistController@tracks')->name('getArtistTracks');
    Route::get('/artist/{id}/audio-features', 'ArtistController@audioFeatures')->name('getArtistAudioFeatures');
    Route::get('/artists/{ids}', 'ArtistController@artists')->name('getArtists');
    Route::get('/album/{id}', 'AlbumController@album')->name('getAlbum');
    Route::get('/album/{id}/tracks', 'AlbumController@tracks')->name('getAlbumTracks');
    Route::get('/album/{id}/audio-features', 'AlbumController@audioFeatures')->name('getAlbumAudioFeatures');
    Route::get('/albums/{ids}', 'AlbumController@albums')->name('getAlbums');
});

Route::post('/uploadTrack', 'UploadController@uploadTrack');
