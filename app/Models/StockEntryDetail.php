<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockEntryDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_entry_id',
        'product_id',
        'quantity',
        'purchase_pricedolar',
        'purchase_pricesol',
        'subtotaldolar',
        'subtotalsol',
    ];

    // Relación con StockEntry
    public function stockEntry()
    {
        return $this->belongsTo(StockEntry::class);
    }

    // Relación con Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
