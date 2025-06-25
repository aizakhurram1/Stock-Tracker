<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    public function inStock()
    {
        return $this->stock()->where('in_stock', true)->exists();
    }

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }

    public function track()
    {
        $this->stock->each->track(
            fn ($stock) => $this->recordHistory($stock)
        );

    }

    public function recordHistory(Stock $stock)
    {
        $this->histories()->create([
            'price' => $stock->price,
            'in_stock' => $stock->in_stock,
            'stock_id' => $stock->id,
        ]);

    }

    public function histories()
    {
        return $this->hasMany(\App\Models\History::class);

    }
}

// entry point in artisan command as it is a cli application
