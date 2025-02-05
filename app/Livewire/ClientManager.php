<?php

namespace App\Livewire;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;

class ClientManager extends Component
{
    use WithPagination;

    public $name, $dni_ruc, $business_name, $phone_number;
    public $client_id;
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
        $clients = Client::when($this->searchTerm, function ($query) {
            $query->where('name', 'like', '%' . $this->searchTerm . '%')
                ->orWhere('dni_ruc', 'like', '%' . $this->searchTerm . '%')
                ->orWhere('business_name', 'like', '%' . $this->searchTerm . '%');
        })
        ->paginate(10);

        return view('livewire.client-manager', [
            'clients' => $clients
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
        $this->dni_ruc = '';
        $this->business_name = '';
        $this->phone_number = '';
        $this->client_id = '';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'dni_ruc' => 'required|unique:clients,dni_ruc,' . $this->client_id,
            'business_name' => 'required',
            'phone_number' => 'required',
        ]);

        Client::updateOrCreate(['id' => $this->client_id], [
            'name' => $this->name,
            'dni_ruc' => $this->dni_ruc,
            'business_name' => $this->business_name,
            'phone_number' => $this->phone_number,
        ]);

        session()->flash('message', $this->client_id ? 'Cliente actualizado con éxito.' : 'Cliente creado con éxito.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);
        $this->client_id = $id;
        $this->name = $client->name;
        $this->dni_ruc = $client->dni_ruc;
        $this->business_name = $client->business_name;
        $this->phone_number = $client->phone_number;

        $this->openModal();
    }

    public function delete($id)
    {
        Client::find($id)->delete();
        session()->flash('message', 'Cliente eliminado con éxito.');
    }
}
