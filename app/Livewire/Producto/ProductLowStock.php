<?php

namespace App\Livewire\Producto;

use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;

class ProductLowStock extends Component
{
    public $products;
    public $menuAbierto = true;
    public $selectedProducts = [];
    public $modalAbierto = false;

    protected $listeners = ['toggleMenu' => 'updateMenuState'];

    public function updateMenuState()
    {
        $this->menuAbierto = !$this->menuAbierto;
    }

    public function mount()
    {
        $this->products = Product::where('stock', '<=', 4)
            ->where('status', 'published')
            ->get();
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

    public function render()
    {
        $selectedProductsDetails = Product::whereIn('id', $this->selectedProducts)->get();

        return view('livewire.producto.product-low-stock', [
            'products' => $this->products,
            'selectedProductsDetails' => $selectedProductsDetails,
        ])->layout('layouts.app');
    }


    public function exportPdf()
    {
        $products = Product::whereIn('id', $this->selectedProducts)->get();

        $pdf = Pdf::loadView('pdf.selected-products', compact('products'));

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'productos_seleccionados.pdf'
        );
    }
}
