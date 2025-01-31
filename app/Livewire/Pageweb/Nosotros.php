<?php

namespace App\Livewire\Pageweb;

use Livewire\Component;

class Nosotros extends Component
{

    public $fotosLocal = [
        'local1.jpg',
        'local2.jpg',
        'local3.jpg',
    ];

    public $fotosCiudad = [
        'ciudad1.jpg',
        'ciudad2.jpg',
    ];

    public function render()
    {
        return view('livewire.pageweb.nosotros')->layout('layouts.index');
    }
}
