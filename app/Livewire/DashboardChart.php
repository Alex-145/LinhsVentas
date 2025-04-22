<?php

namespace App\Livewire;

use App\Models\Sale;
use App\Models\SaleDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DashboardChart extends Component
{
    public $menuAbierto = true;

    protected $listeners = ['toggleMenu' => 'updateMenuState'];

    public function updateMenuState()
    {
        $this->menuAbierto = !$this->menuAbierto;
    }

    public function render()
    {
        // Ventas por Fecha (todas)
        $ventasPorFecha = Sale::select(DB::raw("DATE(sale_date) as fecha"), DB::raw("SUM(total) as total"))
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->pluck('total', 'fecha')
            ->toArray();

        // Ingresos por Marca
        $ingresosPorMarca = SaleDetail::select('brands.name as marca', DB::raw("SUM(sale_details.subtotal) as total"))
            ->join('products', function($join) {
                $join->on('products.id', '=', 'sale_details.salable_id')
                    ->where('sale_details.salable_type', 'App\Models\Product');
            })
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->groupBy('brands.name')
            ->pluck('total', 'marca')
            ->toArray();

        // Ingresos por Categoría
        $ingresosPorCategoria = SaleDetail::select('categories.name as categoria', DB::raw("SUM(sale_details.subtotal) as total"))
            ->join('products', function($join) {
                $join->on('products.id', '=', 'sale_details.salable_id')
                    ->where('sale_details.salable_type', 'App\Models\Product');
            })
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->join('categories', 'brands.category_id', '=', 'categories.id')
            ->groupBy('categories.name')
            ->pluck('total', 'categoria')
            ->toArray();

        return view('livewire.dashboard-chart', [
            'ventasPorFecha' => $ventasPorFecha,
            'ingresosPorMarca' => $ingresosPorMarca,
            'ingresosPorCategoria' => $ingresosPorCategoria,
        ]);
    }
}
