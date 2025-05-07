<?php

namespace App\Livewire\Pageweb;

use App\Models\Product;
use Livewire\Component;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\DB;

class TopProducts extends Component
{
    public $topProducts;

    public function mount()
{
    // Paso 1: obtener los IDs de productos más vendidos
    $topProductIds = SaleDetail::select('salable_id', DB::raw('SUM(quantity) as total_sold'))
        ->where('salable_type', Product::class)
        ->groupBy('salable_id')
        ->orderByDesc('total_sold')
        ->take(4)
        ->pluck('salable_id');

    // Paso 2: obtener los productos con esa ID (incluyendo relaciones necesarias)
    $this->topProducts = Product::with('brand') // carga relaciones necesarias
        ->whereIn('id', $topProductIds)
        ->get();
}
    public function render()
    {
        return view('livewire.pageweb.top-products', [
            'topProducts' => $this->topProducts
        ]);
    }
}
