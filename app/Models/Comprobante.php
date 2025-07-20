<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comprobante extends Model
{
    use HasFactory;

    protected $fillable = [
        'proforma_id',
        'archivo_url',
    ];

    public function proforma()
    {
        return $this->belongsTo(Proforma::class);
    }
}
