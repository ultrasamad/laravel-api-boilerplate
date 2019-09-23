<?php

namespace App\Http\Controllers\Auth\API;

use Hash;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\RegisterUserRequest;


class RegisterController extends Controller
{
    public function __invoke(RegisterUserRequest $request)
    {
        $user = User::create([
            'name'  => $request->input('name'),
            'email' => $request->input('email'),
            'password'  => Hash::make($request->input('password'))
        ]);

        $tokenObj = $user->createToken('laravel-api-boilerplate');
        $token = $tokenObj->accessToken;
        $expiration = Carbon::parse($tokenObj->token->expires_at)->toDateTimeString();

        //Fire registered event which has a sendVerificationEmailNotification listener
        event(new Registered($user));
        
        return response()->json([
            'access_token' => $token,
            'token_type'    => 'Bearer',
            'token_expiration'  => $expiration,
            'user'  => $user
        ]);
        
    }
}
