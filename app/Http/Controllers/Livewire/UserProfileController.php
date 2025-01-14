<?php

namespace App\Http\Controllers\Livewire;

use Laravel\Jetstream\Http\Controllers\Livewire\UserProfileController as JetstreamUserProfileController;
use Illuminate\Http\Request;

class UserProfileController extends JetstreamUserProfileController
{
    public $menuAbierto = true;

    // El método para alternar el estado del menú
    public function updateMenuState()
    {
        $this->menuAbierto = !$this->menuAbierto;
    }

    // El método para mostrar el perfil del usuario
    public function show(Request $request)
    {
        return view('profile.showt', [
            'request' => $request,
            'user' => $request->user(),
            'menuAbierto' => $this->menuAbierto,
        ]);
    }

}
