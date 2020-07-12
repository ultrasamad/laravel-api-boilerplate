<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\RegisterUserRequest;

class UserController extends Controller
{
    /**
     * List all users
     *
     * @return void
     */
    public function index()
    {
        $users = User::paginate();
        return new UserCollection($users);
    }

    /**
     * Display user details
     *
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function show(Request $request, User $user)
    {
        return new UserResource($user);
    }

    /**
     * Create new user
     *
     * @param RegisterUserRequest $request
     * @return void
     */
    public function store(RegisterUserRequest $request)
    {
        $this->authorize('create', User::class);
        $input = $request->only('name', 'email', 'password');
        $input['password'] = Hash::make($request->input('password'));

        $user = User::create($input);

        return new UserResource($user);
    }

    /**
     * Update user
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return void
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $user->update($request->except('password'));
        return new UserResource($user->fresh());
    }

    /**
     * Remove user
     *
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function destroy(Request $request, User $user)
    {
        if ($request->input('permanent') == true) {
            $this->authorize('forceDelete', $user);
            $user->forceDelete();
        }else {
            $this->authorize('delete', $user);
            $user->delete();
        }
       
        return response()->json([
            'message'   => 'User removed successfully!'
        ], 204);
    }
}
