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
        'status',
        'brand_id',
        'photo_url',
    ];


    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->brand ? $this->brand->category() : null;
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
