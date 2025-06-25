<?php

namespace Tests\Clients;

use App\Clients\BestBuy;
use App\Models\Stock;
use Database\Seeders\RetailerWithProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 *  @group api
 */
class BestBuyTest extends TestCase{
    
    use RefreshDatabase;

       /** @test */
       function it_tracks_a_product()
    {
        $this->seed(RetailerWithProduct::class);
        $stock = tap(Stock::first())->update([
            'sku' => '6522225',
            // 'url'=> '"https://api.bestbuy.com/v1/products/6522225.json?apiKey=Q7rwdCDZnWPly3KzbG1KNR5F"',
            'url' => 'https://www.bestbuy.com/site/switch-with-neon-blue-and-neon-red-joycon-nintendo-switch/6522225.p?skuId=6522225'
        ]);

        try{

        $stock_status = (new BestBuy())->checkAvailability($stock);
        } catch (\Exception $e) {

            $this->fail('failed to track the BestBuy Api properly');
        
        }
        $this->assertTrue(true);

       
    }
}