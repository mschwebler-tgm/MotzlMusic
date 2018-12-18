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

