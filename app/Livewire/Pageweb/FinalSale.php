<?php

namespace App\Livewire\Pageweb;

use App\Models\Client;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class FinalSale extends Component
{
    public $cart = [];
    public $total = 0;
    public $subtotal = 0;
    public $igv = 0;

    public $dni, $name, $email, $phone_number, $ruc, $business_name;
    public $message = '';
    public $isNewClient = false;

    public function mount()
    {
        $this->cart = Session::get('cart', []);
        $this->total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $this->cart));
        $this->subtotal = $this->total / 1.18;
        $this->igv = $this->total - $this->subtotal;
    }

    public function searchClient()
    {
        $client = Client::where('dni', $this->dni)->first();

        if ($client) {
            $this->name = $client->name;
            $this->email = $client->email;
            $this->phone_number = $client->phone_number;
            $this->ruc = $client->ruc;
            $this->business_name = $client->business_name;
            $this->message = '';
            $this->isNewClient = false;
        } else {
            $this->reset(['name', 'email', 'phone_number', 'ruc', 'business_name']);
            $this->message = 'Cliente no encontrado. Por favor, complete sus datos.';
            $this->isNewClient = true;
        }
    }

    public function render()
    {
        return view('livewire.pageweb.final-sale')->layout('layouts.index');
    }
}
