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
        return $user->isAdmin() || $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $user->isSelf($model) || $user->isAdmin() || $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('user.create') || $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        /*
        |--------------------------------------------------------------------------
        | Hard blocks
        |--------------------------------------------------------------------------
        */

        // Nobody can modify super_admin
        if ($model->isSuperAdmin()) {

            // except another super_admin
            return $user->isSuperAdmin()
                && !$user->isSelf($model);
        }

        /*
        |--------------------------------------------------------------------------
        | Admin permissions
        |--------------------------------------------------------------------------
        */

        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return true;
        }

        /*
        |--------------------------------------------------------------------------
        | Self update
        |--------------------------------------------------------------------------
        */

        return $user->isSelf($model);
    }


    public function changeRole(User $user, User $model): bool
    {
        /*
        |--------------------------------------------------------------------------
        | Hard blocks
        |--------------------------------------------------------------------------
        */

        // Nobody changes super_admin role
        if ($model->isSuperAdmin()) {
            return false;
        }

        // super_admin cannot change own role
        if ($user->isSuperAdmin() && $user->isSelf($model)) {
            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | Admin permissions
        |--------------------------------------------------------------------------
        */

        return $user->isAdmin() || $user->isSuperAdmin();
    }
    
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        /*
        |--------------------------------------------------------------------------
        | Hard blocks
        |--------------------------------------------------------------------------
        */

        // Nobody deletes super_admin
        if ($model->isSuperAdmin()) {

            // except another super_admin
            return $user->isSuperAdmin()
                && !$user->isSelf($model);
        }

        /*
        |--------------------------------------------------------------------------
        | Admin permissions
        |--------------------------------------------------------------------------
        */

        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return true;
        }

        /*
        |--------------------------------------------------------------------------
        | Self delete
        |--------------------------------------------------------------------------
        */

        return $user->isSelf($model);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->isAdmin() || $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->isAdmin() || $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can view the trash.
     */
    public function viewTrash(User $user): bool
    {
        return $user->isAdmin() || $user->isSuperAdmin();
    }

}