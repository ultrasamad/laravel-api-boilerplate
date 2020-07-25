<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class UserPermissionController extends Controller
{
    /**
     * Update user permissions
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $admin = auth('api')->user();
        abort_unless($admin->can('Update user roles', 'api'), 403, 'You are not authorized to perform this action');

        $names = $request->input('permissions');
        $permissions = Permission::whereIn('name', $names)->get();
        $user->syncPermissions($permissions);

        return response()->json([
            'data' => [
                'error' => false,
                'message' => 'User permissions list updated successfully'
            ]
        ]);
    }
}
