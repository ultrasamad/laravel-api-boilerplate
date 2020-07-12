<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $admin
     * @return mixed
     */
    public function create(User $admin)
    {
        return $admin->can('Create user');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function update(User $admin, User $user)
    {
        return $admin->can('Update user');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $admin
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function delete(User $admin, User $model)
    {
        return $admin->can('Delete user');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function restore(User $user, User $model)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $admin
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function forceDelete(User $admin, User $user)
    {
        return $admin->can('Force delete user');
    }
}
