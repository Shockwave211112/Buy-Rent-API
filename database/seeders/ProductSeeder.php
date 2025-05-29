<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Аккаунт Steam',
            'count' => '10',
            'price' => '15000',
            'rent_price_4h' => '100',
            'rent_price_8h' => '190',
            'rent_price_12h' => '280',
            'rent_price_24h' => '550',
        ]);

        Product::create([
            'name' => 'Аккаунт EpicGames',
            'count' => '12',
            'price' => '10000',
            'rent_price_4h' => '50',
            'rent_price_8h' => '90',
            'rent_price_12h' => '130',
            'rent_price_24h' => '280',
        ]);

        Product::create([
            'name' => 'Аккаунт Xbox',
            'count' => '5',
            'price' => '12500',
            'rent_price_4h' => '70',
            'rent_price_8h' => '130',
            'rent_price_12h' => '190',
            'rent_price_24h' => '370',
        ]);
    }
}
