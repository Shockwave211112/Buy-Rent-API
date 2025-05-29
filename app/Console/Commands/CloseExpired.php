<?php

namespace App\Console\Commands;

use App\Enums\OrderTypeEnum;
use App\Models\Order;
use Illuminate\Console\Command;

class CloseExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:close-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentTime = now();
        $orders = Order::where('type', OrderTypeEnum::Rent)
            ->where('is_active', true)
            ->whereNotNull('end_at')
            ->where('end_at', '<=', $currentTime)
            ->update(['is_active' => false]);

        $this->info("Закрыто $orders заказа(ов) с арендой.");
    }
}
