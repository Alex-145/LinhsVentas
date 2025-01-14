<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ProductManager extends Component
{
    use WithFileUploads, WithPagination;

    public $name, $description, $purchase_price, $sale_price, $stock, $category_id, $brand_id, $photo_url, $photo_url_old, $editMode = false, $isOpen = false;
    public $categories, $brands, $productId;
    public $menuAbierto = true;
    public $searchTerm = '';
    public $photoModalOpen = false;
    public $showConfirmModal = false;
    public $productIdToDelete;

    protected $listeners = ['toggleMenu' => 'updateMenuState'];

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'purchase_price' => 'required|numeric|min:0',
        'sale_price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'category_id' => 'required|exists:categories,id',
        'brand_id' => 'required|exists:brands,id',
        'photo_url' => 'nullable|image|max:1024',
    ];

    public function updateMenuState()
    {
        $this->menuAbierto = !$this->menuAbierto;
    }

    public function mount()
    {
        $this->categories = Category::all();
        $this->brands = Brand::all();
    }
    public function openPhotoModal($id)
    {
        $this->productId = $id;
        $product = Product::findOrFail($id);
        $this->photo_url_old = $product->photo_url;
        $this->photo_url = null;
        $this->photoModalOpen = true;
    }

    public function savePhoto()
    {
        $this->validate([
            'photo_url' => 'required|image|max:1024',
        ]);

        $product = Product::findOrFail($this->productId);

        if ($this->photo_url) {
            $photoUrl = $this->photo_url->store('products', 'public');
            $product->update(['photo_url' => $photoUrl]);
            session()->flash('message', 'Foto actualizada correctamente.');
        }

        $this->photoModalOpen = false;
    }

    public function render()
    {
        $products = Product::with('category', 'brand') // Eager loading para optimizar consultas
            ->orderBy('created_at', 'desc')
            ->when($this->searchTerm, function ($query) {
                $query->where('name', 'like', '%' . addslashes($this->searchTerm) . '%');
            })
            ->paginate(15);

        foreach ($products as $product) {
            $product->profit = $product->sale_price - $product->purchase_price;
        }

        return view('livewire.producto.product-manager', [
            'products' => $products,
        ])->layout('layouts.app');
    }
    public function confirmDelete($productId)
    {
        $this->productIdToDelete = $productId;
        $this->showConfirmModal = true;
    }
// se va
    public function create()
    {
        $this->resetForm();
        $this->isOpen = true;
    }

    public function store()
    {
        $this->validate();

        $photoUrl = $this->photo_url ? $this->photo_url->store('products', 'public') : null;

        Product::create([
            'name' => $this->name,
            'description' => $this->description,
            'purchase_price' => $this->purchase_price,
            'sale_price' => $this->sale_price,
            'stock' => $this->stock,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'photo_url' => $photoUrl,
        ]);

        session()->flash('message', 'Producto creado correctamente.');
        $this->resetForm();
    }

    public function edit($id)
    {
        $this->resetForm();
        $this->productId = $id;
        $this->editMode = true;

        $product = Product::findOrFail($id);
        $this->fill($product->toArray());
        $this->photo_url_old = $product->photo_url;
        $this->isOpen = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
        ]);

        $product = Product::find($this->productId);

        if (!$product) {
            session()->flash('error', 'Producto no encontrado.');
            return;
        }

        $product->update([
            'name' => $this->name,
            'description' => $this->description,
            'purchase_price' => $this->purchase_price,
            'sale_price' => $this->sale_price,
            'stock' => $this->stock,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
        ]);

        session()->flash('message', 'Producto actualizado correctamente.');
        $this->resetForm();
    }


    public function destroy()
    {
        // Asegúrate de que se haya establecido el ID
        if ($this->productIdToDelete) {
            Product::findOrFail($this->productIdToDelete)->delete();
            $this->showConfirmModal = false; // Cierra el modal
            session()->flash('message', 'Producto eliminado exitosamente.');
            $this->resetPage(); // Reinicia la paginación si es necesario
        }
    }

    public function resetForm()
    {
        $this->name = '';
        $this->description = '';
        $this->purchase_price = '';
        $this->sale_price = '';
        $this->stock = '';
        $this->category_id = '';
        $this->brand_id = '';
        $this->photo_url = null;
        $this->photo_url_old = null;
        $this->editMode = false;
        $this->isOpen = false;
    }




}
