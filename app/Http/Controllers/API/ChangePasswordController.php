<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rules\ValidCurrentUserPassword;


class ChangePasswordController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $vData = $request->validate([
            'current-password' => ['required', new ValidCurrentUserPassword],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();

        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'message'   => 'Password changed successfully!'
        ]);

    }
}
