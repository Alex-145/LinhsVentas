<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    protected $fillable = [
        'sale_id',
        'salable_type', // Agregar este campo
        'salable_id',
        'quantity',
        'price',
        'subtotal',
        'utilidad_saledetail',
        'estado_detail',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
    public function salable()
    {
        return $this->morphTo();
    }
}
