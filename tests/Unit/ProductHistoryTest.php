<?php

namespace Tests\Unit;

use App\Clients\StockStatus;
use App\Models\History;
use App\Models\Product;
use Database\Seeders\RetailerWithProduct;
use Facades\App\Clients\ClientFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ProductHistoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_records_product_history()
    {

        $this->seed(RetailerWithProduct::class);

        // Http::fake(fn () => [
        //     'salePrice' => 9900,
        //     'onlineAvailability' => true,

        // ]);
        ClientFactory::shouldReceive('make->checkAvailability')
        ->andReturn(new StockStatus($available = true, $price = 99));

        $product = Product::first();

        $this->assertCount(0, $product->histories);
        $product->track();

         $this->assertCount(2, $product->refresh()->histories);

        // $history = History::first();
        // $stock = $product->stock[0];

        // $this->assertNotNull($history, 'No history record found.');

        // $this->assertEquals($stock->price, $history->price);
        // $this->assertEquals($stock->in_stock, $history->in_stock);
        // $this->assertEquals($stock->product_id, $history->product_id);
        // $this->assertEquals($stock->id, $history->stock_id);

    }
}
