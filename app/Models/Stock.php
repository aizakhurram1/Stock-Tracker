<?php

namespace App\Models;

use Http;
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

        if ($this->retailer->name === 'Best Buy') {
            // Hit an Api endpoint for the associated retailer
            $results = Http::get('http://foo.test')->json();
        }
        // Fetch the up to date details for the items
        // then refresh the stock items

        $this->update([
            'in_stock' => $results['available'],
            'price' => $results['price'],
        ]);
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }
}
