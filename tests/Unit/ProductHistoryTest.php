<?php

namespace Tests\Unit;

use App\Models\History;
use App\Models\Stock;
use Database\Seeders\RetailerWithProduct;
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

        Http::fake(fn () => [
            'salePrice' => 9900,
            'onlineAvailability' => true,

        ]);
        $this->assertEquals(0, History::count());
        $stock = tap(Stock::first())->track();

        $this->assertEquals(1, History::count());

        $history = History::first();

        $history = History::first();

        $this->assertNotNull($history, 'No history record found.');

        $this->assertEquals($stock->price, $history->price);
        $this->assertEquals($stock->in_stock, $history->in_stock);
        $this->assertEquals($stock->product_id, $history->product_id);
        $this->assertEquals($stock->id, $history->stock_id);

    }
}
