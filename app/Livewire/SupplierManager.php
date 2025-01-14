<?php

namespace App\Livewire;

use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;

class SupplierManager extends Component
{
    use WithPagination;

    public $name, $ruc, $cellphone;
    public $supplier_id;
    public $isOpen = false;
    public $menuAbierto = true;
    public $searchTerm = ''; // Propiedad para almacenar el término de búsqueda

    protected $listeners = ['toggleMenu' => 'updateMenuState'];

    public function updateMenuState()
    {
        $this->menuAbierto = !$this->menuAbierto;
    }

    public function render()
    {
        // Modificar la consulta para incluir el filtro de búsqueda
        $suppliers = Supplier::when($this->searchTerm, function ($query) {
            $query->where('name', 'like', '%' . $this->searchTerm . '%')
                ->orWhere('ruc', 'like', '%' . $this->searchTerm . '%');
        })
        ->paginate(10);

        return view('livewire.supplier-manager', [
            'suppliers' => $suppliers
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->ruc = '';
        $this->cellphone = '';
        $this->supplier_id = '';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'ruc' => 'nullable|unique:suppliers,ruc,' . $this->supplier_id,
            'cellphone' => 'nullable',
        ]);

        Supplier::updateOrCreate(['id' => $this->supplier_id], [
            'name' => $this->name,
            'ruc' => $this->ruc,
            'cellphone' => $this->cellphone,
        ]);

        session()->flash('message', $this->supplier_id ? 'Proveedor actualizado con éxito.' : 'Proveedor creado con éxito.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        $this->supplier_id = $id;
        $this->name = $supplier->name;
        $this->ruc = $supplier->ruc;
        $this->cellphone = $supplier->cellphone;

        $this->openModal();
    }

    public function delete($id)
    {
        Supplier::find($id)->delete();
        session()->flash('message', 'Proveedor eliminado con éxito.');
    }
}
