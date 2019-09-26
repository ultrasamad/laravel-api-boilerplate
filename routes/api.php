<?php

//Auth routes
Route::prefix('auth')->group(function(){
    Route::post('login', 'Auth\API\LoginController');
    Route::post('register', 'Auth\API\RegisterController');
    Route::middleware('auth:api')->get('/user', 'Auth\API\UserProfileController');
});

//Email verification
Route::get('email-verification/resend', 'Auth\API\VerificationController@resend')->name('verification.resend');
Route::get('email-verification/verify/{id}', 'Auth\API\VerificationController@verify')->name('api.verification.verify');

//Password reset
Route::get('password/email', 'Auth\API\ForgotPasswordController@sendLink');
Route::post('password/reset', 'Auth\API\ResetPasswordController@doReset')->name('api.password.reset');

//User routes
Route::group(['middleware' => 'auth:api'], function () {
    Route::patch('change-password', 'ChangePasswordController');
    Route::resource('users', 'UserController');
});
