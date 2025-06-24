<?php

namespace Tests\Unit;

use App\Clients\ClientsException;
use App\Models\Retailer;
use App\Models\Stock;
use Database\Seeders\RetailerWithProduct;
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
}
