<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proforma extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'codigo',
        'factura',
        'status',
        'fecha_vencimiento',
        'total',
        'metodo_pago',
        'correo_notificado',
        'fecha_pago',
        'fecha_confirmacion',
        'comprobante_url',
        'convertido_a_venta',
    ];


    protected $casts = [
        'fecha_vencimiento' => 'date',
        'correo_notificado' => 'boolean',
        'fecha_pago' => 'datetime',
        'fecha_confirmacion' => 'datetime',
        'convertido_a_venta' => 'boolean',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function detailProformas()
    {
        return $this->hasMany(ProformaDetail::class);
    }
    public function comprobantes()
    {
        return $this->hasMany(Comprobante::class);
    }
}
