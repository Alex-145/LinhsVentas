<?php

namespace App\Livewire\Pageweb;

use Livewire\Component;

class Service extends Component
{
    public function render()
    {
        return view('livewire.pageweb.service')->layout('layouts.index');
    }
}
