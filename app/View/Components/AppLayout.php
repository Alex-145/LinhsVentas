<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use PHPUnit\Event\Telemetry\GarbageCollectorStatus;

class AppLayout extends Component
{

    public function render()
    {
        // Pasa el valor de $menuAbierto a la vista
        return view('layouts.app');
    }
}
