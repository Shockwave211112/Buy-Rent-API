<?php

namespace App\Observers;

use App\Models\Order;
use Illuminate\Support\Facades\Cache;

class OrderCacheObserver
{
    private function clearCache(Order $order)
    {
        Cache::tags(["User_{$order->user_id}_Orders"])->flush();
    }

    public function updated(Order $order)
    {
        $this->clearCache($order);
    }

    public function created(Order $order)
    {
        $this->clearCache($order);
    }

    public function deleted(Order $order)
    {
        $this->clearCache($order);
    }

    public function forceDeleted(Order $order)
    {
        // ...
    }
}
