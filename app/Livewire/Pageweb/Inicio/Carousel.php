<?php

namespace App\Livewire\Pageweb\Inicio;

use Livewire\Component;

class Carousel extends Component
{
    public $images = [
        'pageweb/llantaspromo.png',
        'pageweb/carrusel15.png',
        // 'pageweb/taller11.png',
    ];

    public $currentIndex = 0;

    public function next()
    {
        $this->currentIndex = ($this->currentIndex + 1) % count($this->images);
    }

    public function prev()
    {
        $this->currentIndex = ($this->currentIndex - 1 + count($this->images)) % count($this->images);
    }

    public function goToSlide($index)
    {
        $this->currentIndex = $index;
    }

    public function render()
    {
        return view('livewire.pageweb.inicio.carousel');
    }
}
