<?php

use Illuminate\Support\Facades\Auth;

Route::get('/', 'HomeController@index')->name('home');
Auth::routes();

Route::get('/{any}', function () {
    return view('master')->with(['user' => Auth::user()]);
})->where('any', '^(?!api\/|storage\/).+')->name('app');
