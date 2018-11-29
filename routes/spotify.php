<?php

# login
use Illuminate\Support\Facades\Route;

Route::get('/authorize', 'AuthController@requestAuthCode');
Route::get('/authorize/landing', 'AuthController@authorizeUser');
