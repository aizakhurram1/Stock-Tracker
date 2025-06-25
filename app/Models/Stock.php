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
        $this->recordHistory();

    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }

    public function histories()
    {
        return $this->hasMany(\App\Models\History::class);

    }

    protected function recordHistory()
    {
        $this->histories()->create([
            'price' => $this->price,
            'in_stock' => $this->in_stock,
            'product_id' => $this->product_id,
        ]);

    }
}
