<?php

use Illuminate\Support\Facades\Auth;

Route::get('/', 'HomeController@index')->name('home');
Auth::routes();

Route::get('/{any}', 'HomeController@app')
    ->where('any', '^(?!api\/|storage\/).+')
    ->name('app');
