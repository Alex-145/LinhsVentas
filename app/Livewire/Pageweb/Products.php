<?php

namespace App\Livewire\Pageweb;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;

    public $search = '';
    public $cart = [];
    public $selectedCategory = '';

    protected $queryString = ['search', 'selectedCategory'];
    protected $listeners = ['cartUpdated' => 'updateCart'];

    public function mount()
    {
        $this->cart = Session::get('cart', []);
    }

    public function updateCart($cart)
    {
        $this->cart = $cart;
        Session::put('cart', $this->cart);
    }

    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);

        if ($product->stock <= 0) {
            $this->dispatch('showStockAlert', 'No hay suficiente stock para este producto.');
            return;
        }

        if (isset($this->cart[$productId])) {
            if ($this->cart[$productId]['quantity'] >= $product->stock) {
                $this->dispatch('showStockAlert', 'No hay suficiente stock para añadir más unidades de este producto.');
                return;
            }
            $this->cart[$productId]['quantity'] += 1;
        } else {
            $this->cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->sale_price,
                'quantity' => 1,
                'photo_url' => $product->photo_url,
            ];
        }

        $this->dispatch('cartUpdated', $this->cart);
        Session::put('cart', $this->cart);
    }

    public function removeFromCart($productId)
    {
        if (isset($this->cart[$productId])) {
            unset($this->cart[$productId]);
            $this->dispatch('cartUpdated', $this->cart);
            Session::put('cart', $this->cart);
        }
    }

    public function render()
    {
        $query = Product::with(['brand.category'])
            ->where('status', 'published');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->selectedCategory) {
            $query->whereHas('brand.category', function ($q) {
                $q->where('id', $this->selectedCategory);
            });
        }

        $products = $query->paginate(12);

        $products->each(function ($product) {
            $product->inCart = isset($this->cart[$product->id]);
        });

        $categories = \App\Models\Category::all();

        return view('livewire.pageweb.products', [
            'products' => $products,
            'categories' => $categories,
        ])->layout('layouts.index');
    }
}
