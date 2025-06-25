<?php

namespace Tests\Clients;

use App\Clients\BestBuy;
use App\Models\Stock;
use Database\Seeders\RetailerWithProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 *  @group api
 */
class BestBuyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_tracks_a_product()
    {
        $this->seed(RetailerWithProduct::class);
        $stock = tap(Stock::first())->update([
            'sku' => '6522225',
            // 'url'=> '"https://api.bestbuy.com/v1/products/6522225.json?apiKey=Q7rwdCDZnWPly3KzbG1KNR5F"',
            'url' => 'https://www.bestbuy.com/site/switch-with-neon-blue-and-neon-red-joycon-nintendo-switch/6522225.p?skuId=6522225',
        ]);

        try {

            $stock_status = (new BestBuy)->checkAvailability($stock);
        } catch (\Exception $e) {

            $this->fail('failed to track the BestBuy Api properly'.$e->getMessage());

        }
        $this->assertTrue(true);

    }

    /** @test */
    public function it_creates_the_proper_stock_status_response()
    {
        Http::fake(fn () => [
            'salePrice' => 299.90,
            'onlineAvailability' => true,

        ]);
        $stock_status = (new BestBuy)->checkAvailability(new Stock);
        $this->assertEquals(29989, $stock_status->price);
        $this->assertEquals(true, $stock_status->available);

    }
}
