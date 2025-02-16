<?php

namespace App\Livewire\Pageweb;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class ProductShow extends Component
{
    public $product;
    public $cart = [];

    protected $listeners = ['cartUpdated' => 'updateCart'];

    public function mount($id)
    {
        $this->product = Product::with(['brand', 'attributes'])->findOrFail($id);
        $this->cart = Session::get('cart', []);
    }

    public function updateCart($cart)
    {
        $this->cart = $cart;
        Session::put('cart', $this->cart);
    }

    public function addToCart()
    {
        if ($this->product->stock <= 0) {
            return;
        }

        if (isset($this->cart[$this->product->id])) {
            if ($this->cart[$this->product->id]['quantity'] >= $this->product->stock) {
                return;
            }
            $this->cart[$this->product->id]['quantity'] += 1;
        } else {
            $this->cart[$this->product->id] = [
                'id' => $this->product->id,
                'name' => $this->product->name,
                'price' => $this->product->sale_price,
                'quantity' => 1,
                'photo_url' => $this->product->photo_url,
            ];
        }

        $this->dispatch('cartUpdated', $this->cart);
        Session::put('cart', $this->cart);
    }

    public function removeFromCart()
    {
        if (isset($this->cart[$this->product->id])) {
            unset($this->cart[$this->product->id]);
            $this->dispatch('cartUpdated', $this->cart);
            Session::put('cart', $this->cart);
        }
    }

    public function render()
    {
        return view('livewire.pageweb.product-show', [
            'product' => $this->product,
            'cart' => $this->cart,
        ])->layout('layouts.index');
    }
}
