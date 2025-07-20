<?php

namespace App\Livewire\Producto;

use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class ProductLowStock extends Component
{
    public $products;
    public $menuAbierto = true;
    public $selectedProducts = [];
    public $modalAbierto = false;

    // Nueva variable para guardar las predicciones
    public $predicciones = [];

    protected $listeners = ['toggleMenu' => 'updateMenuState'];

    public function mount()
    {
        $this->products = Product::where('stock', '<=', 4)
            ->where('status', 'published')
            ->get();

        // Puedes cargar predicciones al inicio si quieres, o dejar vacío
        $this->predicciones = [];
    }

    public function updateMenuState()
    {
        $this->menuAbierto = !$this->menuAbierto;
    }

    public function toggleProduct($productId)
    {
        if (in_array($productId, $this->selectedProducts)) {
            $this->selectedProducts = array_diff($this->selectedProducts, [$productId]);
        } else {
            $this->selectedProducts[] = $productId;
        }
    }

    public function toggleModal()
    {
        $this->modalAbierto = !$this->modalAbierto;
    }

    // Nuevo método para llamar a la API y obtener predicciones
    public function obtenerPredicciones()
    {
        $response = Http::get('http://localhost:8010/prediccion_completa/');

        if ($response->successful()) {
            $prediccionesRaw = $response->json();

            // Extraer los ids de productos y clientes para hacer consultas eficientes
            $clienteIds = collect($prediccionesRaw)->pluck('cliente_id')->unique();
            $productoIds = collect($prediccionesRaw)->pluck('producto_id')->unique();

            // Obtener clientes y productos desde la BD
            $clientes = \App\Models\Client::whereIn('id', $clienteIds)->get()->keyBy('id');
            $productos = \App\Models\Product::whereIn('id', $productoIds)->get()->keyBy('id');

            // Mapear las predicciones para agregar nombres
            $this->predicciones = collect($prediccionesRaw)->map(function ($pred) use ($clientes, $productos) {
                return [
                    'cliente_id' => $pred['cliente_id'],
                    'cliente_nombre' => $clientes[$pred['cliente_id']]->name ?? 'Cliente desconocido',
                    'producto_id' => $pred['producto_id'],
                    'producto_nombre' => $productos[$pred['producto_id']]->name ?? 'Producto desconocido',
                    'proxima_compra_estimada' => $pred['proxima_compra_estimada'] ?? 'N/A',
                    'fecha_publicidad' => $pred['fecha_publicidad'] ?? 'N/A',
                ];
            })->toArray();
        } else {
            $this->predicciones = [];
            $this->dispatch('error', ['message' => 'Error al obtener las predicciones']);
        }
    }


    public function render()
    {
        $selectedProductsDetails = Product::whereIn('id', $this->selectedProducts)->get();

        return view('livewire.producto.product-low-stock', [
            'products' => $this->products,
            'selectedProductsDetails' => $selectedProductsDetails,
            'predicciones' => $this->predicciones,
        ])->layout('layouts.app');
    }

    public function exportPdf()
    {
        $products = Product::whereIn('id', $this->selectedProducts)->get();

        $pdf = Pdf::loadView('pdf.selected-products', compact('products'));

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'productos_seleccionados.pdf'
        );
    }
}
