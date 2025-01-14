<?php

namespace App\Livewire;

use Livewire\Component;

class NavigationMenudos extends Component
{
    public $menuAbierto = true; // Estado del menú lateral
    public $dropdowns = [
        'inventario' => false,
        'ventas' => false,
        'contactos' => false,
    ];

    protected $listeners = ['toggleMenu' => 'updateMenuState'];
    public function updateMenuState()
    {
        $this->menuAbierto = !$this->menuAbierto;
    }
    public function navegar($ruta)
    {
        // Guardar estados en la sesión
        session()->put('menuAbierto', $this->menuAbierto);
        session()->put('dropdowns', $this->dropdowns);
        return redirect()->route($ruta);
    }

    public function toggleDropdown($key)
    {
        $this->dropdowns[$key] = !$this->dropdowns[$key];
    }

    public function mount()
    {
        // Recuperar estados desde la sesión
        $this->menuAbierto = session('menuAbierto', $this->menuAbierto);
        $this->dropdowns = session('dropdowns', $this->dropdowns);
    }

    public function render()
    {
        return view('livewire.navigation-menudos')->layout('layout.app');
    }
}
