<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Category;

class CategoryPolicy
{
    /**
     * Create a new policy instance.
     */
    function create(User $user): bool
    {
        return $user->isAdministrator();
    }
    public function viewAny(User $user): bool
    {
        return $user->isAdministrator(); // เฉพาะแอดมิน
    }

    function update(User $user): bool
    {

        return $this->create($user);
    }


}
