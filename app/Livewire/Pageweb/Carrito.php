<?php

namespace App\Livewire\Pageweb;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class Carrito extends Component
{
    public $isOpen = false;
    public $cart = []; // Array para almacenar los productos en el carrito
    public $subtotal = 0; // Propiedad para almacenar el subtotal


    protected $listeners = ['openCartModal' => 'openModal', 'cartUpdated' => 'updateCart'];

    public function mount()
    {
        // Recuperar el carrito de la sesión al inicializar el componente
        $this->cart = Session::get('cart', []);
        $this->calculateSubtotal(); // Calcular el subtotal inicial
    }

    public function calculateSubtotal()
{
    $this->subtotal = 0; // Reiniciar el subtotal
    foreach ($this->cart as $item) {
        $this->subtotal += $item['price'] * $item['quantity']; // Sumar el precio * cantidad de cada producto
    }
}
    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function updateCart($cart)
{
    $this->cart = $cart; // Actualiza el carrito con los datos recibidos
    $this->calculateSubtotal(); // Recalcular el subtotal
    Session::put('cart', $this->cart); // Guardar el carrito en la sesión
}

    public function removeFromCart($productId)
    {
        if (isset($this->cart[$productId])) {
            unset($this->cart[$productId]); // Elimina el producto del carrito
            $this->dispatch('cartUpdated', $this->cart); // Emite el evento para actualizar el carrito
            Session::put('cart', $this->cart); // Guardar el carrito en la sesión
        }
    }
    public function incrementQuantity($productId)
    {
        if (isset($this->cart[$productId])) {
            $product = Product::findOrFail($productId);

            // Verificar si la cantidad en el carrito más 1 supera el stock
            if ($this->cart[$productId]['quantity'] + 1 > $product->stock) {
                $this->dispatch('showStockAlert', 'No hay suficiente stock para añadir más unidades de este producto.');
                return;
            }

            $this->cart[$productId]['quantity'] += 1; // Incrementa la cantidad
            $this->dispatch('cartUpdated', $this->cart); // Emite el evento para actualizar el carrito
            Session::put('cart', $this->cart); // Guardar el carrito en la sesión
        }
    }
    public function decrementQuantity($productId)
    {
        if (isset($this->cart[$productId])) {
            if ($this->cart[$productId]['quantity'] > 1) {
                $this->cart[$productId]['quantity'] -= 1; // Reduce la cantidad
            } else {
                // Si la cantidad es 1, elimina el producto del carrito
                unset($this->cart[$productId]);
            }

            $this->dispatch('cartUpdated', $this->cart); // Emite el evento para actualizar el carrito
            Session::put('cart', $this->cart); // Guardar el carrito en la sesión
        }
    }

    public function render()
    {
        return view('livewire.pageweb.carrito');
    }
}
