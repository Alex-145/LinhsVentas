<?php

namespace App\Livewire;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Brand;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DashboardChart extends Component
{
    public $menuAbierto = true;
    public $fechaInicio;
    public $fechaFin;
    public $marcaSeleccionada = '';
    public $categoriaSeleccionada = '';
    public $filtrosAplicados = false; // Nuevo estado para controlar cuando se aplican los filtros


    protected $listeners = ['toggleMenu' => 'updateMenuState'];

    public function mount()
    {
        $this->establecerFechasPorDefecto();
    }

    public function updateMenuState()
    {
        $this->menuAbierto = !$this->menuAbierto;
    }

    public function aplicarFiltros()
    {
        if ($this->fechaInicio > $this->fechaFin) {
            $this->addError('fechaInicio', 'La fecha de inicio no puede ser mayor que la fecha fin.');
            return;
        }

        $this->filtrosAplicados = true; // Marcar que los filtros han sido aplicados
        $this->emitirDatosGraficos();
    }

    public function updated($property)
    {
        if (in_array($property, ['fechaInicio', 'fechaFin', 'marcaSeleccionada', 'categoriaSeleccionada'])) {
            // No emitir datos automáticamente, esperar al botón aplicar
            // Solo marcamos que los filtros no están aplicados
            $this->filtrosAplicados = false;
        }
    }

    public function resetearFiltros()
    {
        $this->reset(['fechaInicio', 'fechaFin', 'marcaSeleccionada', 'categoriaSeleccionada', 'filtrosAplicados']);
        $this->establecerFechasPorDefecto();
        $this->emitirDatosGraficos();
    }


    private function aplicarFiltrosProducto($query)
    {
        return $query
            ->join('products', function ($join) {
                $join->on('products.id', '=', 'sale_details.salable_id')
                    ->where('sale_details.salable_type', 'App\Models\Product');
            })
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->join('categories', 'brands.category_id', '=', 'categories.id')
            ->when($this->marcaSeleccionada, fn($q) => $q->where('brands.id', $this->marcaSeleccionada))
            ->when($this->categoriaSeleccionada, fn($q) => $q->where('categories.id', $this->categoriaSeleccionada));
    }

    private function obtenerKPIs()
    {
        $ventas = Sale::whereBetween('sale_date', [$this->fechaInicio, $this->fechaFin]);

        $totalVentas = $ventas->sum('total');
        $totalTransacciones = $ventas->count();
        $ventaPromedio = $totalTransacciones > 0 ? $totalVentas / $totalTransacciones : 0;

        $detalles = SaleDetail::join('sales', 'sale_details.sale_id', '=', 'sales.id')
            ->whereBetween('sales.sale_date', [$this->fechaInicio, $this->fechaFin]);

        $detalles = $this->aplicarFiltrosProducto($detalles);

        $totalProductos = $detalles->sum('quantity');

        return compact('totalVentas', 'totalTransacciones', 'ventaPromedio', 'totalProductos');
    }

    private function obtenerVentasPorFecha()
    {
        return Sale::whereBetween('sale_date', [$this->fechaInicio, $this->fechaFin])
            ->select(DB::raw("DATE(sale_date) as fecha"), DB::raw("SUM(total) as total"))
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->pluck('total', 'fecha')
            ->toArray();
    }

    private function obtenerIngresosPorMarca()
    {
        $query = SaleDetail::select('brands.name as marca', DB::raw("SUM(sale_details.subtotal) as total"))
            ->join('sales', 'sale_details.sale_id', '=', 'sales.id')
            ->whereBetween('sales.sale_date', [$this->fechaInicio, $this->fechaFin]);

        $query = $this->aplicarFiltrosProducto($query);

        return $query
            ->groupBy('brands.name')
            ->pluck('total', 'marca')
            ->toArray();
    }

    private function obtenerIngresosPorCategoria()
    {
        $query = SaleDetail::select('categories.name as categoria', DB::raw("SUM(sale_details.subtotal) as total"))
            ->join('sales', 'sale_details.sale_id', '=', 'sales.id')
            ->whereBetween('sales.sale_date', [$this->fechaInicio, $this->fechaFin]);

        $query = $this->aplicarFiltrosProducto($query);

        return $query
            ->groupBy('categories.name')
            ->pluck('total', 'categoria')
            ->toArray();
    }

    protected function emitirDatosGraficos()
    {
        $ventas = $this->obtenerVentasPorFecha();
        $marcas = $this->obtenerIngresosPorMarca();
        $categorias = $this->obtenerIngresosPorCategoria();

        $this->dispatch(
            'chartsUpdated',
            ventas: $ventas,
            marcas: $marcas,
            categorias: $categorias
        )->to(static::class); // Envía el evento solo a este componente
    }

    private function establecerFechasPorDefecto()
    {
        $this->fechaFin = Carbon::now()->format('Y-m-d');
        $this->fechaInicio = Carbon::now()->subDays(30)->format('Y-m-d');
        $this->filtrosAplicados = true; // Considerar los valores por defecto como aplicados
    }

    // ... (resto de métodos permanecen iguales)

    public function render()
    {
        try {
            $kpis = $this->obtenerKPIs();

            $marcas = Brand::orderBy('name')->get();
            $categorias = Category::orderBy('name')->get();

            return view('livewire.dashboard-chart', array_merge($kpis, [
                'ventasPorFecha' => $this->filtrosAplicados ? $this->obtenerVentasPorFecha() : [],
                'ingresosPorMarca' => $this->filtrosAplicados ? $this->obtenerIngresosPorMarca() : [],
                'ingresosPorCategoria' => $this->filtrosAplicados ? $this->obtenerIngresosPorCategoria() : [],
                'marcas' => $marcas,
                'categorias' => $categorias,
                'filtrosAplicados' => $this->filtrosAplicados,
            ]));
        } catch (\Exception $e) {
            report($e);
            return view('livewire.dashboard-chart')->withErrors(['error' => 'Hubo un problema al generar el dashboard.']);
        }
    }
}
