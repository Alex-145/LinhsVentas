<?php

namespace App\Livewire;

use App\Models\Service;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ServiceManager extends Component
{
    use WithFileUploads, WithPagination;

    public $name, $description, $price, $serviceId;
    public $editMode = false, $isOpen = false;
    public $searchTerm = '';
    public $showConfirmModal = false;
    public $serviceIdToDelete;
    public $menuAbierto = true;
    protected $listeners = ['toggleMenu' => 'updateMenuState'];

    public function updateMenuState()
    {
        $this->menuAbierto = !$this->menuAbierto;
    }

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
    ];

    public function render()
    {
        $services = Service::orderBy('created_at', 'desc')
            ->when($this->searchTerm, function ($query) {
                $query->where('name', 'like', '%' . addslashes($this->searchTerm) . '%');
            })
            ->paginate(15);

        return view('livewire.service-manager', [
            'services' => $services,
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->resetForm();
        $this->isOpen = true;
    }

    public function store()
    {
        $this->validate();

        Service::create([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
        ]);

        session()->flash('message', 'Servicio creado correctamente.');
        $this->resetForm();
    }

    public function edit($id)
    {
        $this->resetForm();
        $this->serviceId = $id;
        $this->editMode = true;

        $service = Service::findOrFail($id);
        $this->fill($service->toArray());
        $this->isOpen = true;
    }

    public function update()
    {
        $this->validate();

        $service = Service::find($this->serviceId);

        if (!$service) {
            session()->flash('error', 'Servicio no encontrado.');
            return;
        }

        $service->update([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
        ]);

        session()->flash('message', 'Servicio actualizado correctamente.');
        $this->resetForm();
    }

    public function confirmDelete($serviceId)
    {
        $this->serviceIdToDelete = $serviceId;
        $this->showConfirmModal = true;
    }

    public function destroy()
    {
        if ($this->serviceIdToDelete) {
            Service::findOrFail($this->serviceIdToDelete)->delete();
            $this->showConfirmModal = false;
            session()->flash('message', 'Servicio eliminado exitosamente.');
            $this->resetPage();
        }
    }

    public function resetForm()
    {
        $this->name = '';
        $this->description = '';
        $this->price = '';
        $this->editMode = false;
        $this->isOpen = false;
    }
}
