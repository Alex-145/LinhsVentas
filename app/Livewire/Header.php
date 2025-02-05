<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Sale;
use Livewire\Component;

class Header extends Component
{
    public $menuAbierto = true;
    public $currentRoute = null; // Agregar una propiedad para almacenar la ruta actual
    public $hasPending = false; // Bandera para ventas pendientes
    public $lowStockProducts = []; // Productos con bajo stock
    public $open = false;
    public $isPendienteFacturacion = true;


    protected $listeners = [
        'toggleMenu' => 'updateMenuState',
        'checkPendingSales',
        'saleCreated',
        'checkLowStock', // Agregar nuevo listener
    ];


    public function checkLowStock()
    {
        // Obtener productos con stock <= 4 y status 'published'
        $this->lowStockProducts = Product::where('stock', '<=', 4)
            ->where('status', 'published')
            ->get();

        // Emitir un evento para notificar si hay productos con bajo stock
        if ($this->lowStockProducts->isNotEmpty()) {
            $this->dispatch('show-low-stock-notification', ['products' => $this->lowStockProducts]);
        }
    }


    public function toggleModal()
    {
        $this->open = !$this->open;
    }

    public function mount()
    {
        // Inicializa la ruta actual cuando se monta el componente
        $this->currentRoute = request()->route()->getName();
        $this->checkPendingSales(); // Verifica facturas pendientes
        $this->checkLowStock(); // Verifica productos con bajo stock
    }


    public function checkPendingSales()
    {
        $hasPendingNow = Sale::where('status_fac', 'pendiente_facturacion')->exists();
        $hasPlayed = session('has_played_sound', false);

        if ($hasPendingNow && !$hasPlayed) {
            $this->dispatch('play-notification-sound');
            session(['has_played_sound' => true]);
        } elseif (!$hasPendingNow) {
            session()->forget('has_played_sound');
        }

        $this->hasPending = $hasPendingNow;
    }


    // Este es el método que deberías llamar después de crear o modificar una venta
    public function saleCreated(Sale $sale)
    {
        $this->checkPendingSales();  // Verifica si hay ventas pendientes
    }


    public function resetNotificationFlag()
    {
        // Limpiar la variable de sesión que indica si el sonido ha sido emitido
        session()->forget('has_played_sound');
    }

    public function toggleMenu()
    {
        $this->dispatch('toggleMenu');
    }

    public function updateMenuState()
    {
        $this->menuAbierto = !$this->menuAbierto;
    }


    public function navegar($ruta)
{
    // Guardar el estado del filtro en la sesión
    session()->put('isPendienteFacturacion', true);

    // Redirigir a la ruta con los parámetros adicionales
    return redirect()->route($ruta, ['isPendienteFacturacion' => true]);
}





    public function render()
    {
        return view('livewire.header', [
            'hasNotifications' => $this->hasPending || $this->lowStockProducts->isNotEmpty(),
        ])->layout('layouts.app');
    }
}
