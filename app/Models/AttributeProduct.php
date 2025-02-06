<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeProduct extends Model
{

    protected $table = 'attribute_products';  // Nombre de la tabla intermedia

    protected $fillable = [
        'product_id',
        'attribute_id',
        'value',
    ];
}
