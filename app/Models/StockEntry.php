<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'user_id',
        'reception_date',
        'total_dollar',
        'currency',
        'dollar_value',
        'total_soles',
    ];

    // Relación con Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    // Relación con StockEntryDetail
    public function stockEntryDetails()
    {
        return $this->hasMany(StockEntryDetail::class);
    }
    // Relación con User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
