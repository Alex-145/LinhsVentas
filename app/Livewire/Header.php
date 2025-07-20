<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Proforma;
use App\Models\Sale;
use Livewire\Component;

class Header extends Component
{
    public $menuAbierto = true;
    public $currentRoute = null;
    public $hasPending = false;
    public $lowStockProducts = [];
    public $open = false;
    public $isPendienteFacturacion = true;
    public $hasVerificacionPendiente = false;
    public $lastNotificationCount = 0;
    public $initialCheckDone = false; // Nueva propiedad

    protected $listeners = [
        'toggleMenu' => 'updateMenuState',
        'checkPendingSales',
        'saleCreated',
        'checkLowStock',
    ];

    public function checkVerificacionesPendientes()
    {
        $this->hasVerificacionPendiente = Proforma::where('status', 'esperando_verificacion')->exists();
        $this->triggerNotificationIfNeeded();
    }
    private function triggerNotificationIfNeeded()
    {
        // Solo verificar después de la carga inicial
        if (!$this->initialCheckDone) return;

        $currentCount = $this->getTotalNotifications();
        $previousCount = session('last_notification_count', 0);

        if ($currentCount > $previousCount) {
            $this->dispatch('play-notification-sound');
        }

        session(['last_notification_count' => $currentCount]);
    }



    public function mount()
    {
        $this->currentRoute = request()->route()->getName();
        $this->checkPendingSales();
        $this->checkLowStock();
        $this->checkVerificacionesPendientes();

        // Marcar que la verificación inicial ya se hizo
        $this->initialCheckDone = true;
    }

    private function getTotalNotifications(): int
    {
        $count = 0;
        if ($this->hasPending) $count++;
        if ($this->lowStockProducts && count($this->lowStockProducts) > 0) $count++;
        if ($this->hasVerificacionPendiente) $count++;
        return $count;
    }



    public function toggleModal()
    {
        $this->open = !$this->open;
    }

    public function toggleMenu()
    {
        $this->dispatch('toggleMenu');
    }

    public function updateMenuState()
    {
        $this->menuAbierto = !$this->menuAbierto;
    }

    public function checkLowStock()
    {
        $this->lowStockProducts = Product::where('stock', '<=', 4)
            ->where('status', 'published')
            ->get();

        $this->triggerNotificationIfNeeded();
    }

    public function checkPendingSales()
    {
        $this->hasPending = Sale::where('status_fac', 'pendiente_facturacion')
            ->where('estado_sale', '!=', 'anulado_sale')
            ->exists();

        $this->triggerNotificationIfNeeded();
    }


    public function saleCreated(Sale $sale)
    {
        $this->checkPendingSales();
    }

    public function resetNotificationFlag()
    {
        session()->forget('has_played_sound');
    }

    public function navegar($ruta)
    {
        session()->put('isPendienteFacturacion', true);
        return redirect()->route($ruta, ['isPendienteFacturacion' => true]);
    }

    public function render()
    {
        return view('livewire.header', [
            'hasNotifications' => $this->hasPending || $this->lowStockProducts->isNotEmpty() || $this->hasVerificacionPendiente,
        ])->layout('layouts.app');
    }
}
