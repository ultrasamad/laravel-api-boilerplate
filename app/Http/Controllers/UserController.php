<?php

namespace App\Http\Controllers;

use Hash;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdateUserRequest;


class UserController extends Controller
{
    public function __construct()
    {
        //
    }
    public function index()
    {
        $users = User::get();
        return response()->json([
            'message'   => 'User registered successfully!',
            'users' => $users
        ]);
    }

    public function show(Request $request, User $user)
    {
        return response()->json([
            'user'  => $user,
        ]);
    }

    public function store(RegisterUserRequest $request)
    {
        $input = $request->only('name', 'email', 'password');
        $input['password'] = Hash::make($request->input('password'));

        $user = User::create($input);

        return response()->json([
            'user'   => $user
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->except('password'));
        return response()->json([
            'message'   => 'User information updated successfully!',
            'user'  => $user,
        ]);
    }

    public function destroy(Request $request, User $user)
    {
        $user->delete();

        return response()->json([
            'message'   => 'User removed successfully!'
        ], 204);
    }
}
