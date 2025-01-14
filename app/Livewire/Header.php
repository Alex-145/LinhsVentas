<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Livewire;

class Header extends Component
{
    public $menuAbierto = true;
    public $currentRoute = null; // Agregar una propiedad para almacenar la ruta actual

    protected $listeners = ['toggleMenu' => 'updateMenuState'];
    public $open = false;

    public function toggleModal()
    {
        $this->open = !$this->open;
    }

    public function mount()
    {
        // Inicializa la ruta actual cuando se monta el componente
        $this->currentRoute = request()->route()->getName();
    }

    public function toggleMenu()
    {
        $this->dispatch('toggleMenu');
    }

    public function updateMenuState()
    {
        $this->menuAbierto = !$this->menuAbierto;
    }

    public function render()
    {
        return view('livewire.header')->layout('layouts.app');
    }
}
