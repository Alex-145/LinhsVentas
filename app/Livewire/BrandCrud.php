<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class BrandCrud extends Component
{
    use WithFileUploads, WithPagination;

    public $name, $category_id, $brandId;
    public $categories;
    public $openForm = false;
    public $brandToDelete = null;
    public $openDeleteConfirm = false;
    public $url_imgbrand, $url_imgbrand_old;
    public $photoModalOpen = false;
    public $menuAbierto = true;
    public $relatedProductsCount = 0;
    public $brandNameToDelete = '';

    // Propiedades para búsqueda y filtrado
    public $search = '';
    public $categoryFilter = '';

    public function updateMenuState()
    {
        $this->menuAbierto = !$this->menuAbierto;
    }

    protected $listeners = ['toggleMenu' => 'updateMenuState'];

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function render()
    {
        $brands = Brand::query()
            ->with(['category', 'products'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->categoryFilter, function ($query) {
                $query->where('category_id', $this->categoryFilter);
            })
            ->withCount('products')
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.brand-crud', [
            'brands' => $brands
        ])->layout('layouts.app');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function openPhotoModal($id)
    {
        $brand = Brand::findOrFail($id);
        $this->brandId = $id;
        $this->url_imgbrand_old = $brand->url_imgbrand;
        $this->photoModalOpen = true;
    }

    public function savePhoto()
    {
        $this->validate([
            'url_imgbrand' => 'nullable|image|max:1024',
        ]);

        $brand = Brand::findOrFail($this->brandId);

        if ($this->url_imgbrand) {
            $urlImgbrand = $this->url_imgbrand->store('brands', 'public');
            $brand->update(['url_imgbrand' => $urlImgbrand]);
        }

        session()->flash('message', 'Foto actualizada correctamente.');
        $this->photoModalOpen = false;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'url_imgbrand' => 'nullable|image|max:1024',
        ]);

        $urlImgbrand = $this->url_imgbrand ? $this->url_imgbrand->store('brands', 'public') : null;

        if ($this->brandId) {
            $brand = Brand::find($this->brandId);
            $brand->update([
                'name' => $this->name,
                'category_id' => $this->category_id,
                'url_imgbrand' => $urlImgbrand ?? $brand->url_imgbrand,
            ]);
            session()->flash('message', 'Marca actualizada con éxito.');
        } else {
            Brand::create([
                'name' => $this->name,
                'category_id' => $this->category_id,
                'url_imgbrand' => $urlImgbrand,
            ]);
            session()->flash('message', 'Marca creada con éxito.');
        }

        $this->reset(['name', 'category_id', 'brandId', 'url_imgbrand']);
        $this->openForm = false;
    }

    public function create()
    {
        $this->reset(['name', 'category_id', 'brandId', 'url_imgbrand']);
        $this->openForm = true;
    }

    public function edit($id)
    {
        $brand = Brand::find($id);
        $this->brandId = $brand->id;
        $this->name = $brand->name;
        $this->category_id = $brand->category_id;
        $this->openForm = true;
    }

    public function prepareDelete($id)
    {
        $brand = Brand::withCount('products')->find($id);
        $this->brandToDelete = $id;
        $this->brandNameToDelete = $brand->name;
        $this->relatedProductsCount = $brand->products_count;
        $this->openDeleteConfirm = true;
    }

    public function delete()
    {
        if ($this->brandToDelete) {
            $brand = Brand::find($this->brandToDelete);

            if ($brand) {
                if ($brand->products()->exists()) {
                    session()->flash('error', 'No se puede eliminar la marca porque tiene productos asociados.');
                } else {
                    $brand->delete();
                    session()->flash('message', 'Marca eliminada con éxito.');
                }
            } else {
                session()->flash('error', 'Marca no encontrada.');
            }

            $this->resetDeleteConfirmation();
        }
    }

    public function resetDeleteConfirmation()
    {
        $this->brandToDelete = null;
        $this->brandNameToDelete = '';
        $this->relatedProductsCount = 0;
        $this->openDeleteConfirm = false;
    }

    public function closeModal()
    {
        $this->openForm = false;
        $this->photoModalOpen = false;
        $this->openDeleteConfirm = false;
    }
}
