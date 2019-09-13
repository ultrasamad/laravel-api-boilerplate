<?php

use Illuminate\Http\Request;

//Auth routes
Route::prefix('auth')->group(function(){
    Route::post('login', 'Auth\API\LoginController');
    Route::post('register', 'Auth\API\RegisterController');
    Route::middleware('auth:api')->get('/user', 'Auth\API\UserProfileController');
});

//User routes
Route::group(['middleware' => 'auth:api'], function () {
    Route::resource('users', 'UserController');
});
