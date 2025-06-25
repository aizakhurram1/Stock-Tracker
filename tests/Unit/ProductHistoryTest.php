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
       
        $history = $product->histories->first();



        $this->assertEquals($price, $history->price);
        $this->assertEquals($available, $history->in_stock);
        $this->assertEquals($product->id, $history->product_id);
        $this->assertEquals($product->stock[0]->id, $history->stock_id);

    }
}
