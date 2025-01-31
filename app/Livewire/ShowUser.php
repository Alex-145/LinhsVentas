<?php

namespace App\Livewire;

use Livewire\Component;

class ShowUser extends Component
{
    public $menuAbierto = true;
    protected $listeners = ['toggleMenu' => 'updateMenuState'];

    public function updateMenuState()
    {
        $this->menuAbierto = !$this->menuAbierto;
    }
    public function render()
    {
        return view('profile.show')->layout('layouts.app');
    }
}
