<?php

use Illuminate\Support\Facades\Auth;

Route::get('/', 'HomeController@index')->name('home');
Auth::routes();

Route::get('/{any}', function () {
    $user = Auth::user();
    if (!$user) {
        return redirect('/login');
    }
    return view('master')->with(['user' => $user]);
})->where('any', '^(?!api\/|storage\/).+')->name('app');
