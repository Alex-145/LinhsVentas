<?php

namespace App\Livewire;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;

class ClientManager extends Component
{
    use WithPagination;

    public $name, $dni, $ruc, $business_name, $phone_number, $email;
    public $client_id;
    public $isOpen = false;
    public $menuAbierto = true;
    public $searchTerm = '';

    protected $listeners = ['toggleMenu' => 'updateMenuState'];

    public function updateMenuState()
    {
        $this->menuAbierto = !$this->menuAbierto;
    }

    public function render()
    {
        $clients = Client::when($this->searchTerm, function ($query) {
            $query->where('name', 'like', '%' . $this->searchTerm . '%')
                ->orWhere('dni', 'like', '%' . $this->searchTerm . '%')
                ->orWhere('ruc', 'like', '%' . $this->searchTerm . '%')
                ->orWhere('business_name', 'like', '%' . $this->searchTerm . '%')
                ->orWhere('phone_number', 'like', '%' . $this->searchTerm . '%')
                ->orWhere('email', 'like', '%' . $this->searchTerm . '%');
        })->paginate(10);

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
        $this->dni = '';
        $this->ruc = '';
        $this->business_name = '';
        $this->phone_number = '';
        $this->email = '';
        $this->client_id = '';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'dni' => 'nullable|unique:clients,dni,' . $this->client_id,
            'ruc' => 'nullable|unique:clients,ruc,' . $this->client_id,
            'business_name' => 'nullable',
            'phone_number' => 'nullable',
            'email' => 'nullable|email|unique:clients,email,' . $this->client_id,
        ]);

        Client::updateOrCreate(['id' => $this->client_id], [
            'name' => $this->name,
            'dni' => $this->dni ?: null,
            'ruc' => $this->ruc ?: null,
            'business_name' => $this->business_name ?: null,
            'phone_number' => $this->phone_number ?: null,
            'email' => $this->email ?: null, // Convierte cadena vacía a null
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
        $this->dni = $client->dni;
        $this->ruc = $client->ruc;
        $this->business_name = $client->business_name;
        $this->phone_number = $client->phone_number;
        $this->email = $client->email;

        $this->openModal();
    }

    public function delete($id)
    {
        Client::find($id)->delete();
        session()->flash('message', 'Cliente eliminado con éxito.');
    }
}
