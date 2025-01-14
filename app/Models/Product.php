<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'purchase_price',
        'sale_price',
        'stock',
        'category_id',
        'brand_id',
        'photo_url',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    // public function saleDetails()
    // {
    //     return $this->hasMany(SaleDetail::class);
    // }

    public function saleDetails()
    {
        return $this->morphMany(SaleDetail::class, 'salable');
    }
    public function stockEntryDetails()
    {
        return $this->hasMany(StockEntryDetail::class);
    }
}
