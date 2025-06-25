<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    /** @use HasFactory<\Database\Factories\StockFactory> */
    use HasFactory;

    protected $table = 'stock';

    protected $casts = [
        'in_stock' => 'boolean',
    ];

    public function track($callback = null)
    {
        $stock_status = $this->retailer->client()->checkAvailability($this);

        $this->update([
            'in_stock' => $stock_status->available,
            'price' => $stock_status->price,
        ]);

        $callback && $callback($this);

        $this->product->recordHistory($this);
        // $this->recordHistory();

    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

// index file to implement http only cookie not using any languages
