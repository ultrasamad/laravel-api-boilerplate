<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Detail\UserResource;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class UserProfileController extends Controller
{
    /**
     * View user profile
     *
     * @param Request $request
     * @return UserResource
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();
        return new UserResource($user);
    }
}
