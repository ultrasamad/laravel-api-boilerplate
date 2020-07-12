<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    
    /**
     * Assign roles to a user
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request, User $user)
    {
        $admin = auth('api')->user();
        abort_unless($admin->can('Update user roles', 'api'), 403, 'You are not authorized to perform this action');

        $names = $request->input('roles');
        $roles = Role::whereIn('name', $names)->get();
        $user->syncRoles($roles);

        return response()->json([
            'data' => [
                'error' => false,
                'message' => 'User roles list updated successfully'
            ]
        ]);
    }
}
