<?php

use Illuminate\Support\Facades\Route;

//Auth routes
Route::prefix('auth')->group(function(){
    Route::post('login', 'API\Auth\LoginController')->name('auth.login');
    Route::post('register', 'API\Auth\RegisterController')->name('auth.register');
    Route::get('logout', 'API\Auth\LogoutController@logout')->name('auth.logout');
    Route::middleware('auth:api')->get('user', 'API\UserProfileController');
});

//Email verification
Route::get('email-verification/resend', 'API\Auth\VerificationController@resend')->name('verification.resend');
Route::get('email-verification/verify/{id}', 'API\Auth\VerificationController@verify')->name('api.verification.verify');

//Password reset
Route::get('password/email', 'API\Auth\ForgotPasswordController@sendLink');
Route::post('password/reset', 'API\Auth\ResetPasswordController@doReset')->name('api.password.reset');

//User routes
Route::group(['middleware' => 'auth:api'], function () {
    Route::patch('change-password', 'API\ChangePasswordController');
    Route::apiResource('users', 'API\UserController');
});

//Roles and Permissions
Route::get('roles', 'API\RoleController@index')->name('roles.index');
Route::get('permissions', 'API\PermissionController@index')->name('permissions.index');
//Update roles of a user
Route::patch('user/{user}/roles', 'API\UserRoleController@update')->name('user.roles.update');
//Assign permissions to a user
Route::patch('user/{user}/permissions', 'API\UserPermissionController@update')->name('user.permissions.update');
