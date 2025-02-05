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
        'more' => false,
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

    public function navegarinicio($ruta)
    {
        return redirect()->to($ruta);
    }

    public function navegarsales($ruta)
    {
        // Guardar el estado del filtro en la sesión
        session()->put('isPendienteFacturacion', false);

        // Redirigir a la ruta con los parámetros adicionales
        return redirect()->route($ruta, ['isPendienteFacturacion' => false]);
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
