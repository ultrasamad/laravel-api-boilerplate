<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\LogoutController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\UserProfileController;
use App\Http\Controllers\API\Auth\VerificationController;
use App\Http\Controllers\API\Auth\ForgotPasswordController;
use App\Http\Controllers\API\Auth\ResetPasswordController;
use App\Http\Controllers\API\ChangePasswordController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\API\UserRoleController;
use App\Http\Controllers\API\UserPermissionController;

//Auth routes
Route::prefix('auth')->group(function(){
    Route::post('login', LoginController::class)->name('auth.login');
    Route::post('register', RegisterController::class)->name('auth.register');
    Route::get('logout', LogoutController::class)->name('auth.logout');
    Route::middleware('auth:api')->get('user', UserProfileController::class);
});

//Email verification
Route::get('email-verification/resend', [VerificationController::class, 'resend'])->name('verification.resend');
Route::get('email-verification/verify/{id}', [VerificationController::class, 'verify'])->name('api.verification.verify');

//Password reset
Route::get('password/email', [ForgotPasswordController::class, 'sendLink']);
Route::post('password/reset', [ResetPasswordController::class, 'doReset'])->name('api.password.reset');

//User routes
Route::group(['middleware' => 'auth:api'], function () {
    Route::patch('change-password', ChangePasswordController::class);
    Route::apiResource('users', UserController::class);
});

//Roles and Permissions
Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');
//Update roles of a user
Route::patch('user/{user}/roles', [UserRoleController::class, 'update'])->name('user.roles.update');
//Assign permissions to a user
Route::patch('user/{user}/permissions', [UserPermissionController::class, 'update'])->name('user.permissions.update');
