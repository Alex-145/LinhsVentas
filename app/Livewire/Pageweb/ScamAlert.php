<?php

namespace App\Livewire\Pageweb;

use Livewire\Component;

class ScamAlert extends Component
{
    public $showModal = false;

    public function mount()
    {
        // Verificar si la sesión tiene el flag 'scam_alert_shown' o si han pasado 40 minutos
        if (!session()->has('scam_alert_shown') || session('scam_alert_shown') < now()->subMinutes(40)->timestamp) {
            $this->showModal = true;
            // Guardar el tiempo en que se mostró el modal
            session(['scam_alert_shown' => now()->timestamp]);
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.pageweb.scam-alert');
    }
}
