<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    function list(): bool
    {

        // All authenticated user can list

        return true;
    }

    function view(User $user): bool
    {

        // Same as list action

        return $user->isAdministrator();
    }

    function create(User $user): bool
    {

        return $user->isAdministrator();
    }

    function update(User $user): bool
    {

        // Same as create action.

        return $this->create($user);
    }

    function delete(User $user, User $targetUser): bool
    {

        // Same as update action,

        // we consider delete is a special case of update.

        return $user->email !== $targetUser->email;
    }
    function updateselves(User $user, User $targetUser): bool
    {

        // Same as update action,

        // we consider delete is a special case of update.

        return $user->getKey() == $targetUser->getKey();

    }
}