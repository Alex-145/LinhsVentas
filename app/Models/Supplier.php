<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'name',
        'cellphone',
        'ruc',
    ];

    // Relación con StockEntry
    public function stockEntries()
    {
        return $this->hasMany(StockEntry::class);
    }
}
