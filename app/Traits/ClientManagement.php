<?php

namespace App\Traits;

use App\Models\Client;

trait ClientManagement
{
    public $name, $dni, $ruc, $business_name, $phone_number, $email;

    public function buscarDni()
    {
        // Copia el mismo método de ClientManager
    }

    public function buscarRuc()
    {
        // Copia el mismo método de ClientManager
    }

    public function storeClient()
    {
        $this->validate([
            'name' => 'required',
            'dni' => 'nullable|unique:clients,dni',
            'ruc' => 'nullable|unique:clients,ruc',
            'email' => 'nullable|email|unique:clients,email',
        ]);

        $client = Client::create([
            'name' => $this->name,
            'dni' => $this->dni ?: null,
            'ruc' => $this->ruc ?: null,
            'business_name' => $this->business_name ?: null,
            'phone_number' => $this->phone_number ?: null,
            'email' => $this->email ?: null,
        ]);

        $this->resetClientFields();
        return $client;
    }

    private function resetClientFields()
    {
        $this->reset(['name', 'dni', 'ruc', 'business_name', 'phone_number', 'email']);
    }
}
