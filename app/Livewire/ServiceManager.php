<?php

namespace App\Livewire;

use App\Models\Service;
use App\Models\Sale; // Importamos el modelo Sale para verificar dependencias
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
    public $showDependenciesWarning = false;
    public $serviceIdToDelete;
    public $dependenciesCount = 0;
    public $menuAbierto = true;

    protected $listeners = ['toggleMenu' => 'updateMenuState'];

    public function updateMenuState()
    {
        $this->menuAbierto = !$this->menuAbierto;
    }

    protected $rules = [
        'name' => 'required|string|max:255|unique:services,name,' . '$this->serviceId',
        'description' => 'nullable|string|max:500',
        'price' => 'required|numeric|min:0|max:999999.99',
    ];

    protected $messages = [
        'name.required' => 'El nombre del servicio es obligatorio.',
        'name.unique' => 'Este nombre de servicio ya existe.',
        'price.required' => 'El precio es obligatorio.',
        'price.numeric' => 'El precio debe ser un número.',
        'price.min' => 'El precio no puede ser negativo.',
    ];

    public function render()
    {
        $services = Service::orderBy('created_at', 'desc')
            ->when($this->searchTerm, function ($query) {
                $query->where('name', 'like', '%' . addslashes($this->searchTerm) . '%')
                    ->orWhere('description', 'like', '%' . addslashes($this->searchTerm) . '%');
            })
            ->paginate(10);

        return view('livewire.service-manager', [
            'services' => $services,
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->resetForm();
        $this->isOpen = true;
        $this->dispatch('service-modal-opened');
    }

    public function store()
    {
        $this->validate();

        Service::create([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
        ]);

        session()->flash('notify', [
            'type' => 'success',
            'message' => 'Servicio creado correctamente.'
        ]);

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
        $this->dispatch('service-modal-opened');
    }

    public function update()
    {
        $this->validate();

        $service = Service::find($this->serviceId);

        if (!$service) {
            session()->flash('notify', [
                'type' => 'error',
                'message' => 'Servicio no encontrado.'
            ]);
            return;
        }

        $service->update([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
        ]);

        session()->flash('notify', [
            'type' => 'success',
            'message' => 'Servicio actualizado correctamente.'
        ]);

        $this->resetForm();
    }


    public function confirmDelete($serviceId)
    {
        $this->serviceIdToDelete = $serviceId;

        // Verificar si el servicio está siendo usado en ventas
        $this->dependenciesCount = Sale::where('service_id', $serviceId)->count();

        if ($this->dependenciesCount > 0) {
            $this->showDependenciesWarning = true;
        } else {
            $this->showConfirmModal = true;
        }
    }

    public function forceDelete()
    {
        if ($this->serviceIdToDelete) {
            try {
                Service::findOrFail($this->serviceIdToDelete)->delete();

                $this->showConfirmModal = false;
                $this->showDependenciesWarning = false;

                session()->flash('notify', [
                    'type' => 'success',
                    'message' => 'Servicio eliminado exitosamente.'
                ]);

                $this->resetPage();
            } catch (\Exception $e) {
                session()->flash('notify', [
                    'type' => 'error',
                    'message' => 'Error al eliminar el servicio.'
                ]);
            }
        }
    }


    public function resetForm()
    {
        $this->reset(['name', 'description', 'price', 'serviceId', 'editMode', 'isOpen']);
        $this->resetErrorBag();
    }
}
