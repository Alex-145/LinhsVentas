<?php

namespace App\Livewire\Pageweb;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Support\Facades\Session;

class Products extends Component
{
    use WithPagination;

    public $search = '';
    public $cart = [];
    public $selectedCategory = '';
    public $selectedBrands = [];
    public $selectedAttributes = [];


    protected $queryString = ['search', 'selectedCategory', 'selectedBrands', 'selectedAttributes'];
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
        $products = $this->getFilteredProducts();
        $this->markProductsInCart($products);

        return view('livewire.pageweb.products', [
            'products' => $products,
            'categories' => $this->getCategories(),
            'brands' => $this->getBrands(),
            'attributes' => $this->loadAttributes(),
        ])->layout('layouts.index');
    }

    private function getFilteredProducts()
    {
        $query = Product::with(['brand.category', 'attributes'])
            ->where('status', 'published');

        $this->applySearchFilter($query);
        $this->applyCategoryFilter($query);
        $this->applyBrandFilter($query);
        $this->applyAttributeFilter($query);

        return $query->paginate(12);
    }

    private function applySearchFilter($query)
    {
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }
    }

    private function applyCategoryFilter($query)
    {
        if ($this->selectedCategory) {
            $query->whereHas('brand.category', function ($q) {
                $q->where('id', $this->selectedCategory);
            });
        }
    }

    private function applyBrandFilter($query)
    {
        if (!empty($this->selectedBrands)) {
            $query->whereIn('brand_id', $this->selectedBrands);
        }
    }

    private function applyAttributeFilter($query)
    {
        if (!empty($this->selectedAttributes)) {
            foreach ($this->selectedAttributes as $attributeId => $values) {
                // Si $values no es un array, lo convertimos en uno
                if (!is_array($values)) {
                    $values = [$values];
                }

                // Filtra los valores en donde el checkbox está marcado (true)
                $validValues = array_keys(array_filter($values, function ($value) {
                    return $value !== false; // Solo mantenemos los valores que no sean `false`
                }));

                if (!empty($validValues)) {
                    $query->whereHas('attributes', function ($q) use ($attributeId, $validValues) {
                        $q->where('attribute_id', $attributeId)
                            ->whereIn('attribute_products.value', $validValues);
                    });
                }
            }
        }
    }




    private function markProductsInCart($products)
    {
        $products->each(function ($product) {
            $product->inCart = isset($this->cart[$product->id]);
        });
    }

    private function getBrands()
    {
        return Brand::whereHas('products', function ($q) {
            $q->where('status', 'published');
        })->get();
    }

    private function getCategories()
    {
        return Category::whereHas('brands.products', function ($q) {
            $q->where('status', 'published');
        })->get();
    }

    private function loadAttributes()
    {
        return Attribute::whereHas('products', function ($q) {
            $q->where('status', 'published');
        })->with(['products' => function ($q) {
            $q->withPivot('value');
        }])->get();
    }
}
