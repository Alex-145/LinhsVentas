<?php

namespace App\Livewire;

use App\Models\Brand;
use Livewire\Component;

class BrandCrud extends Component
{
    public $brands, $name, $brandId;
    public $isEdit = false;

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public $menuAbierto = true;

    protected $listeners = ['toggleMenu' => 'updateMenuState'];

    public function updateMenuState()
    {
        $this->menuAbierto = !$this->menuAbierto;
    }

    public function render()
    {
        $this->brands = Brand::all();
        return view('livewire.brand-crud')->layout('layouts.app');
    }

    public function resetInput()
    {
        $this->name = null;
        $this->brandId = null;
        $this->isEdit = false;
    }

    public function store()
    {
        $this->validate();
        Brand::create(['name' => $this->name]);
        session()->flash('message', 'Marca creada con éxito.');
        $this->resetInput();
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        $this->brandId = $brand->id;
        $this->name = $brand->name;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate();
        $brand = Brand::findOrFail($this->brandId);
        $brand->update(['name' => $this->name]);
        session()->flash('message', 'Marca actualizada con éxito.');
        $this->resetInput();
    }

    public function delete($id)
    {
        Brand::findOrFail($id)->delete();
        session()->flash('message', 'Marca eliminada con éxito.');
    }
}
