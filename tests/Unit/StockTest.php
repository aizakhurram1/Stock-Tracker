<?php

namespace Tests\Unit;

use App\Clients\ClientsException;
use App\Clients\StockStatus;
use App\Models\Retailer;
use App\Models\Stock;
use Database\Seeders\RetailerWithProduct;
use Facades\App\Clients\ClientFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase; // ✅ use Laravel's base test case

class StockTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_throws_an_exception_when_client_does_not_exist()
    {
        $this->seed(RetailerWithProduct::class);

        Retailer::first()->update([
            'name' => 'Foo Retailer',
        ]);

        $this->expectException(ClientsException::class);

        Stock::first()->track();
    }

    /** @test */
    public function it_updates_loal_stock_status_after_being_tracked()
    {

        $this->seed(RetailerWithProduct::class);

        ClientFactory::shouldReceive('make->checkAvailability')->andReturn(
            new StockStatus($available = true, $price = 9900)
        );

        $stock = tap(Stock::first())->track();

        $this->assertTrue($stock->in_stock);
        $this->assertEquals(9900, $stock->price);

    }
}
