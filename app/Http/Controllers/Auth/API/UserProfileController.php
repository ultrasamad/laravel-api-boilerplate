<?php

namespace App\Http\Controllers\Auth\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserProfileController extends Controller
{
    public function __invoke(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ]);
    }
}
