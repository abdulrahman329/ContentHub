<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('user.create') || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return (
            $user->id === $model->id
        ) || (
            $user->hasRole('admin') && !$model->hasRole('super_admin')
        );
    }

    public function changeRole(User $user, User $model): bool
    {
        return $user->hasRole('admin') && !$model->hasRole('super_admin');
    }
    
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {

    // super_admin cannot be deleted
    if ($model->hasRole('super_admin')) {
        return false;
    }

    // admin can delete any user except super_admin, other users can only delete their own account
    return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->hasRole('admin');
    }

    public function viewTrash(User $user): bool
    {
        return $user->hasRole('admin');
    }
}
