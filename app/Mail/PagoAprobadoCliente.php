<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PagoAprobadoCliente extends Mailable
{
    use Queueable, SerializesModels;

    public $proforma;

    public function __construct($proforma)
    {
        $this->proforma = $proforma;
    }

    public function build()
    {
        return $this->subject('Confirmación de pago aprobado - Linhs Llantas')
            ->view('emails.pago-aprobado');
    }
}
