<?php

namespace App\Livewire;

use Livewire\Component;

class Footer extends Component
{
    public $socialLinks = [
        ['name' => 'Facebook', 'url' => 'https://facebook.com'],
        ['name' => 'Twitter', 'url' => 'https://twitter.com'],
        ['name' => 'Instagram', 'url' => 'https://instagram.com'],
    ];

    public function render()
    {
        return view('livewire.footer');
    }
}
