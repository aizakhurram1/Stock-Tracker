<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Stock;
use Database\Seeders\RetailerWithProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TrackCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_tracks_product_stock()
    {
        $this->seed(RetailerWithProduct::class);

        $this->assertFalse(Product::first()->inStock());

        Http::fake([
            '*' => Http::response([
                'onlineAvailability' => true,
                'salePrice' => 299.00,
            ], 200),
        ]);
        // $this->assertFalse($stock->fresh()->in_stock);
        $this->artisan('track');
        $this->assertTrue(Product::first()->inStock());

    }
}
