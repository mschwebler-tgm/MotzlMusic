<?php

Route::get('/', 'HomeController@index')->name('home');
Auth::routes();

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!api\/|storage\/).+')->name('app');
