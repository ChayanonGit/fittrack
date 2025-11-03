<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;

class OrderdetailPolicy
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
        return $user->role === 'USER';
    }

    function update(User $user): bool
    {

        return $this->viewAny($user);
    }

    function delete(User $user, Order $order): bool
    {

        // to make sure there is products_count.

    $order->loadCount('products');
    return $this->update($user) && ($order->products_count === 0);
    }
}
