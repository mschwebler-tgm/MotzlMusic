<?php

use Illuminate\Support\Facades\Auth;

Route::get('/', 'HomeController@index')->name('home');
Auth::routes();

Route::post('/file/uploadTrack', 'FileController@uploadTrack');
Route::get('/file/track/{id}', 'FileController@getTrackFile');

Route::get('/{any}', 'HomeController@app')
    ->where('any', '^(?!api\/|storage\/).+')
    ->name('app');
