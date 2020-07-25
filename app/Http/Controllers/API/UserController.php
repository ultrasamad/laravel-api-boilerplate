<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\Detail\UserResource;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class UserController extends Controller
{
    /**
     * List all users
     *
     * @return UserCollection
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
     * @return UserResource
     */
    public function show(Request $request, User $user)
    {
        return new UserResource($user->load(['roles', 'permissions']));
    }

    /**
     * Create new user
     *
     * @param RegisterUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterUserRequest $request)
    {
        $this->authorize('create', User::class);
        $input = $request->only('name', 'email', 'password');
        $input['password'] = Hash::make($request->input('password'));
        User::create($input);

        return response()->json([
            'data' => [
                'error' => false,
                'message' => 'User created successfully',
            ]
        ]);
    }

    /**
     * Update user
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return UserResource
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
     * @return \Illuminate\Http\Response
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
        return response()->noContent(204);
    }
}
