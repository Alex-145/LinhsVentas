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
    public $confirmingStatusChange = false;
    public $selectedProductId;
    public $selectedProduct;




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

    // Método para actualizar las marcas cuando cambia la categoría
    public function updatedCategoryId($value)
    {
        $this->brands = Brand::where('category_id', $value)->get();
        $this->brand_id = null; // Resetear la marca seleccionada al cambiar la categoría
    }

    public function openPhotoModal($id)
    {
        $this->productId = $id;
        $product = Product::findOrFail($id);
        $this->photo_url_old = $product->photo_url;
        $this->photo_url = null;
        $this->photoModalOpen = true;
    }

    public function confirmStatusChange($productId)
    {
        $this->selectedProductId = $productId;
        $this->selectedProduct = Product::find($productId); // Cargar el producto
        $this->confirmingStatusChange = true;
    }


    public function toggleStatus()
    {
        $product = Product::find($this->selectedProductId);
        $product->status = $product->status === 'published' ? 'unpublished' : 'published';
        $product->save();

        $this->confirmingStatusChange = false;
        $this->selectedProductId = null;
        $this->selectedProduct = null;

        $this->dispatch('checkLowStock');
        session()->flash('message', 'El estado del producto ha sido actualizado.');
    }


    public function savePhoto()
    {
        $this->validate([
            'photo_url' => 'nullable|image|max:1024',
        ]);

        $product = Product::findOrFail($this->productId);

        if ($this->photo_url) {
            $photoUrl = $this->photo_url->store('products', 'public');
            $product->update(['photo_url' => $photoUrl]);
        }

        session()->flash('message', 'Foto actualizada correctamente.');
        $this->photoModalOpen = false;
    }

    public function updateBrands($categoryId)
    {
        $this->brands = Brand::where('category_id', $categoryId)->get();
        $this->brand_id = null; // Resetea la marca seleccionada
    }

    public function render()
    {
        $products = Product::with('brand.category')  // Eager loading de 'brand' y 'category'
            ->orderBy('created_at', 'desc')
            ->when($this->searchTerm, function ($query) {
                $query->where('name', 'like', '%' . addslashes($this->searchTerm) . '%');
            })
            ->paginate(15);

        foreach ($products as $product) {
            // Verifica si la marca y la categoría existen
            $product->category_name = $product->brand ? ($product->brand->category ? $product->brand->category->name : 'Sin categoría') : 'Sin marca';
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
        $this->productId = $id;
        $this->editMode = true;

        $product = Product::findOrFail($id);
        $this->category_id = $product->brand->category_id;
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

        $this->dispatch('checkLowStock');
        $this->editMode = false;
        $this->isOpen = false;
        session()->flash('message', 'Producto actualizado correctamente.');
    }

    public function destroy()
    {
        // Asegúrate de que se haya establecido el ID
        if ($this->productIdToDelete) {
            Product::findOrFail($this->productIdToDelete)->delete();
            $this->showConfirmModal = false; // Cierra el modal
            session()->flash('message', 'Producto eliminado exitosamente.');
            $this->resetPage(); // Reinicia la paginación si es necesario
        } else {
            session()->flash('error', 'No se pudo eliminar el producto.');
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
        $this->brands = []; // Resetear las marcas
    }
}
