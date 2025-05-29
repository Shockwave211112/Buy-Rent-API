<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductCacheObserver
{
    private function clearCache()
    {
        Cache::tags('Product')->flush();
    }

    public function updated(Product $product)
    {
        $this->clearCache();
    }

    public function created(Product $product)
    {
        $this->clearCache();
    }

    public function deleted(Product $product)
    {
        $this->clearCache();
    }

    public function forceDeleted(Product $product)
    {
        // ...
    }
}
