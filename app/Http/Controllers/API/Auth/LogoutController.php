<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * Log user out
     *
     * @param Request $request
     * @return void
     */
    public function __invoke(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'data' => [
                'message' => 'User logged out successfully',
            ]
        ]);
    }
}
