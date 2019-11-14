<?php

namespace App\Http\Controllers;

use Hash;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function __construct()
    {
        //
    }
    public function index()
    {
        $users = User::paginate();
        return new UserCollection($users);
    }

    public function show(Request $request, User $user)
    {
        return new UserResource($user);
    }

    public function store(RegisterUserRequest $request)
    {
        $input = $request->only('name', 'email', 'password');
        $input['password'] = Hash::make($request->input('password'));

        $user = User::create($input);

        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->except('password'));
        return new UserResource($user->fresh());
    }

    public function destroy(Request $request, User $user)
    {
        $user->delete();

        return response()->json([
            'message'   => 'User removed successfully!'
        ], 204);
    }
}
