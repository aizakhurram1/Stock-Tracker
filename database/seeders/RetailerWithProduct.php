<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use Illuminate\Database\Seeder;

class RetailerWithProduct extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $switch = Product::create(['name' => 'Nintendo Switch']);
        $best_buy = Retailer::create(['name' => 'Best Buy']);

        $stock = new Stock([
            'price' => 10000,
            'url' => 'http://foo.com',
            'sku' => '12345',
            'in_stock' => false,

        ]);

        $best_buy->addStock($switch, $stock);
    }
}
