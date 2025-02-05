<?php

namespace App\Livewire\Pageweb;

use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Header extends Component
{
    public $cart = [];
    public $totalItems = 0;

    protected $listeners = ['cartUpdated' => 'updateCart'];

    public function mount()
    {
        // Recuperar el carrito de la sesión al inicializar el componente
        $this->cart = Session::get('cart', []);
        $this->totalItems = $this->getTotalItems();
    }

    public function updateCart($cart)
    {
        $this->cart = $cart; // Actualiza el carrito con los datos recibidos
        $this->totalItems = $this->getTotalItems(); // Actualiza el total de productos
    }

    public function getTotalItems()
    {
        return array_reduce($this->cart, function ($carry, $item) {
            return $carry + $item['quantity'];
        }, 0);
    }

    public function render()
    {
        return view('livewire.pageweb.header');
    }

    public function clearCart()
{
    $this->cart = [];
    Session::forget('cart'); // Eliminar el carrito de la sesión
    $this->dispatch('cartUpdated', $this->cart); // Emitir el evento para actualizar el carrito
}
}
