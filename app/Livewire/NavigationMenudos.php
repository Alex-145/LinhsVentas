<?php

namespace App\Livewire;

use Livewire\Component;

class NavigationMenudos extends Component
{
    public $menuAbierto = true; // Estado del menú lateral

    // Estados de los dropdowns para persistencia
    public $dropdownStates = [
        'inventario' => false,
        'ventas' => false,
        'contactos' => false,
        'more' => false,
    ];

    protected $listeners = ['toggleMenu' => 'updateMenuState'];

    public function mount()
    {
        // Recuperar estados desde la sesión
        $this->menuAbierto = session('menuAbierto', $this->menuAbierto);

        // Cargar estados de los dropdowns desde la sesión
        $savedDropdowns = session('dropdowns', []);
        foreach ($this->dropdownStates as $key => $value) {
            $this->dropdownStates[$key] = $savedDropdowns[$key] ?? $value;
        }
    }

    public function updateMenuState()
    {
        $this->menuAbierto = !$this->menuAbierto;
        $this->saveStates();
    }

    public function toggleDropdown($key)
    {
        $this->dropdownStates[$key] = !$this->dropdownStates[$key];
        $this->saveStates();
    }

    public function navegarsales($ruta)
    {
        $this->saveStates();
        session()->put('isPendienteFacturacion', false);
        return redirect()->route($ruta, ['isPendienteFacturacion' => false]);
    }

    private function saveStates()
    {
        // Guardar estados en la sesión
        session()->put('menuAbierto', $this->menuAbierto);
        session()->put('dropdowns', $this->dropdownStates);
    }

    public function render()
    {
        // Pasar los estados a las vistas Alpine.js
        return view('livewire.navigation-menudos', [
            'dropdownStates' => $this->dropdownStates,
            'menuAbierto' => $this->menuAbierto,
        ])->layout('layout.app');
    }
}
