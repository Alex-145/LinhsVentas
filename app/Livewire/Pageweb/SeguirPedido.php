<?php

namespace App\Livewire\Pageweb;

use App\Models\Proforma;
use Livewire\Component;

class SeguirPedido extends Component
{
    public $mostrarModal = false;
    public $codigoIngresado = '';

    public function verificarCodigo()
    {
        $proforma = Proforma::where('codigo', $this->codigoIngresado)->first();

        if ($proforma) {
            // Redirige a la ruta con el código como query param
            return redirect()->route('verificar.pedido', ['codigo' => $this->codigoIngresado]);
        } else {
            session()->flash('error', 'Código no encontrado.');
        }
    }

    public function render()
    {
        return view('livewire.pageweb.seguir-pedido');
    }
}
