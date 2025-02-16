<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'dni',
        'ruc',
        'business_name',
        'phone_number',
        'email',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

}
