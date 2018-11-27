<?php

Route::get('/', 'HomeController@index')->name('home');
Route::get('/spotify/authorize', '\App\Http\Controllers\Auth\Socialite\SpotifyAuthController@redirectToProvider');
Route::get('/spotify/authorize/landing', '\App\Http\Controllers\Auth\Socialite\SpotifyAuthController@handleProviderCallback');
Auth::routes();

Route::get('/{any}', function () {
    return view('master');
})->where('any', '^(?!api\/|storage\/).+')->name('app');
