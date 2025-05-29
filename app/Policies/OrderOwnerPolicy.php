<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderOwnerPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function view(User $user, Order $order): bool
    {
        return $user->id === $order->user_id;
    }

    /**
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function extend(User $user, Order $order): bool
    {
        return $user->id === $order->user_id;
    }
}
