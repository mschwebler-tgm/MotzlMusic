<?php

Route::get('/authorize', 'AuthController@requestAuthCode');
Route::get('/authorize/landing', 'AuthController@authorizeUser');