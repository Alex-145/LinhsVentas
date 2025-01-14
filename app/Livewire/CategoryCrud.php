<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class CategoryCrud extends Component
{
    public $categories, $name, $categoryId;
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
        $this->categories = Category::all();
        return view('livewire.category-crud')->layout('layouts.app');
    }

    public function resetInput()
    {
        $this->name = null;
        $this->categoryId = null;
        $this->isEdit = false;
    }

    public function store()
    {
        $this->validate();
        Category::create(['name' => $this->name]);
        session()->flash('message', 'Categoría creada con éxito.');
        $this->resetInput();
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate();
        $category = Category::findOrFail($this->categoryId);
        $category->update(['name' => $this->name]);
        session()->flash('message', 'Categoría actualizada con éxito.');
        $this->resetInput();
    }

    public function delete($id)
    {
        Category::findOrFail($id)->delete();
        session()->flash('message', 'Categoría eliminada con éxito.');
    }
}
