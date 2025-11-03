<?php

namespace App\Policies;

use App\Models\FitnessCourse;
use App\Models\User;

class FitnessCoursePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
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
