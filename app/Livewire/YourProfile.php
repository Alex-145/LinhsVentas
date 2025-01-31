<?php

namespace App\Livewire;

use Livewire\Component;

class YourProfile extends Component
{
    protected $listeners = ['toggleMenu' => 'updateMenuState'];
    public $menuAbierto = true;

    public function updateMenuState()
    {
        $this->menuAbierto = !$this->menuAbierto;
    }
    public function render()
    {
        return view('livewire.your-profile')->layout('layouts.app');
    }
}
