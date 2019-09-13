<?php

namespace App\Http\Controllers\Auth\API;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;

class LoginController extends Controller
{
    public function __invoke(LoginUserRequest $request)
    {
        $credentials = [
            'email' => $request->input('email'),
            'password'  => $request->input('password')
        ];

        if (auth()->attempt($credentials)) {

            $user = $request->user();

            $tokenObj = $user->createToken('laravel-api-boilerplate');
            $token = $tokenObj->accessToken;
            $expiration = Carbon::parse($tokenObj->token->expires_in)->toDateTimeString();
            
            return response()->json([
                'access_token' => $token,
                'token_type'    => 'Bearer',
                'token_expiration'  => $expiration,
                'user'  => $user
            ]);
        }

        return response()->json([
            'message'   => 'Invalid credentials!'
        ], 401);
    }
}
