<?php

namespace App\Policies;

use App\Models\User;

class ProductPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user): bool
    {
        return $user->isAdministrator(); // เฉพาะแอดมิน
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


}
