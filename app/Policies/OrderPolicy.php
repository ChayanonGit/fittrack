<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy

{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }


    public function view(User $user): bool
    {
   
        return $user->isAdministrator();
    }


    function update(User $user ,Order $order): bool
    {

        return $this->view($user,$order);
    }

}
