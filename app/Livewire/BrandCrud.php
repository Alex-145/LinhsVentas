<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;

class BrandCrud extends Component
{
    use WithFileUploads;

    public $name, $category_id, $brandId;
    public $categories;
    public $brands = [];
    public $openForm = false;
    public $brandToDelete = null;
    public $openDeleteConfirm = false;
    public $url_imgbrand, $url_imgbrand_old;
    public $photoModalOpen = false;
    public $menuAbierto = true;
    public function updateMenuState()
    {
        $this->menuAbierto = !$this->menuAbierto;
    }

    protected $listeners = ['toggleMenu' => 'updateMenuState'];

    public function mount()
    {
        $this->loadBrands();
    }

    public function loadBrands()
    {
        $this->categories = Category::all();
        $this->brands = Brand::with('category')->get();
    }

    public function render()
    {
        return view('livewire.brand-crud')->layout('layouts.app');
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
        $this->loadBrands();
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

        $this->loadBrands();
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

    public function delete()
    {
        if ($this->brandToDelete) {
            $brand = Brand::find($this->brandToDelete);
            if ($brand) {
                $brand->delete();
                session()->flash('message', 'Marca eliminada con éxito.');
            } else {
                session()->flash('message', 'Marca no encontrada.');
            }

            $this->loadBrands();
            $this->brandToDelete = null;
            $this->openDeleteConfirm = false;
        }
    }
}
