<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProformaDetail extends Model
{
    use HasFactory;

    protected $table = 'detail_proformas';
    protected $fillable = [
        'proforma_id',
        'product_id',
        'quantity',
        'price',
        'subtotal',
    ];

    protected $casts = [
        'price' => 'float',
        'subtotal' => 'float',
    ];

    // Relación con Proforma
    public function proforma()
    {
        return $this->belongsTo(Proforma::class);
    }

    // (Opcional) Relación con producto si tienes
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
