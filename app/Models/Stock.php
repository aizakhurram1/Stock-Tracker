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

    public function track()
    {
        $stock_status = $this->retailer->client()->checkAvailability($this);

        $this->update([
            'in_stock' => $stock_status->available,
            'price' => $stock_status->price,
        ]);
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }
}
