<?php

namespace App\Policies;

use App\Models\User;

class CartPolicy
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
    public function viewcart(User $user): bool
    {
        return $this->list($user);
        
    }
}
