<?php

namespace App\Policies;

use App\Models\Law;
use App\Models\User;

class LawPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Law $law): bool
    {

        return $law->managers()->where('user_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Law $law): bool
    {
        return $law->managers()->where('user_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Law $law): bool
    {
        //
        return $law->managers()->where('user_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Law $law): bool
    {
        return $law->managers()->where('user_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Law $law): bool
    {
        return $law->managers()->where('user_id', $user->id)->exists();
    }

    public function report(User $user, Law $law): bool
    {
        return $law->managers()->where('user_id', $user->id)->exists();
    }

    public function massUpload(User $user, Law $law): bool
    {
        return $law->managers()->where('user_id', $user->id)->exists();
    }
}
