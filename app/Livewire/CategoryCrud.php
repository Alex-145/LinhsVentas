<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryCrud extends Component
{
    use WithPagination;

    public $name, $categoryId, $search = '';
    public $isEdit = false;
    public $menuAbierto = true;
    public $showModal = false;
    public $deleteId = null;
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $productsCount = 0;

    protected $rules = [
        'name' => 'required|string|max:255|unique:categories,name',
    ];

    protected $messages = [
        'name.required' => 'El nombre de la categoría es obligatorio',
        'name.unique' => 'Esta categoría ya existe',
    ];

    protected $listeners = ['toggleMenu' => 'updateMenuState'];

    public function updateMenuState()
    {
        $this->menuAbierto = !$this->menuAbierto;
    }

    public function render()
    {
        $categories = Category::when($this->search, function ($query) {
            return $query->where('name', 'like', '%' . $this->search . '%');
        })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.category-crud', compact('categories'))
            ->layout('layouts.app', ['title' => 'Gestión de Categorías']);
    }

    public function openModal()
    {
        $this->resetInput();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetInput();
    }

    public function resetInput()
    {
        $this->reset(['name', 'categoryId', 'isEdit']);
        $this->resetErrorBag();
    }

    public function store()
    {
        $this->validate();

        Category::create(['name' => $this->name]);
        session()->flash('success', 'Categoría creada con éxito.');
        $this->closeModal();
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->isEdit = true;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $this->categoryId,
        ]);

        $category = Category::findOrFail($this->categoryId);
        $category->update(['name' => $this->name]);
        session()->flash('success', 'Categoría actualizada con éxito.');
        $this->closeModal();
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;

        // Buscar cuántos productos están relacionados con esta categoría a través de las marcas
        $this->productsCount = Product::whereHas('brand', function ($query) use ($id) {
            $query->where('category_id', $id);
        })->count();
    }


    public function delete()
    {
        $category = Category::findOrFail($this->deleteId);

        // Verificar si hay productos asociados
        if ($this->productsCount > 0) {
            session()->flash('error', 'No se puede eliminar la categoría porque tiene productos asociados.');
            return;
        }

        $category->delete();
        session()->flash('success', 'Categoría eliminada con éxito.');
        $this->deleteId = null;
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }
}
