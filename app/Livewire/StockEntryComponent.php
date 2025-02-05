<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\StockEntry;
use App\Models\Supplier;
use Livewire\Component;

class StockEntryComponent extends Component
{
    public $menuAbierto = true;
    public $showlist = false;
    public $search = "";
    public $results = [];
    public $products = [];
    public $quantities = [];
    public $pricesdolar = [];
    public $pricessol = [];
    public $supplierSearch = "";
    public $supplierResults = [];
    public $selectedSupplier = null;
    public $showConfirmationModal = false;
    public $validationMessage = '';
    public $currency = 'sol'; // Moneda
    public $subtotalsol = [];
    public $subtotaldollar = [];
    public $total_dollar = 0;
    public $total_soles = 0; // Total en soles
    public $total_dollar_forsin = 0; // Valor del dólar
    public $total_soles_forsin = 0; // Total en soles
    public $disableInputs = false;

    public function updatedProducts()
    {
        $this->disableInputs = count($this->products) > 0;
    }



    public $dollar_value = 0; // Valor del dólar
    public $reception_date;

    protected $listeners = ['toggleMenu' => 'updateMenuState'];

    public function updateMenuState()
    {
        $this->menuAbierto = !$this->menuAbierto;
    }

    public function changeCurrency()
    {
        $this->currency = $this->currency == 'sol' ? 'dolar' : 'sol';
    }

    public function updateValueCurrency()
    {
        if ($this->currency == 'dolar') {
            $this->currency = 'sol';
            $this->dollar_value = 0;
        } else {
            $this->currency = 'dolar';
        }
    }

    public function calculateDollarValue()
    {
        // Convertir las propiedades a números o establecerlas en 0 si son null
        $totalSoles = is_numeric($this->total_soles) ? (float)$this->total_soles : 0;
        $totalDollar = is_numeric($this->total_dollar) ? (float)$this->total_dollar : 0;

        if ($totalDollar > 0) {
            $this->dollar_value = $totalSoles / $totalDollar;
        } else {
            $this->dollar_value = 0; // Establecer un valor numérico predeterminado
        }
    }

    // Abrir modal de confirmación
    public function openConfirmationModal()
    {
        $this->validationMessage = ''; // Limpiar el mensaje previo
        $this->showConfirmationModal = true; // Mostrar el modal
    }
    // Cerrar modal de confirmación
    public function closeConfirmationModal()
    {
        $this->showConfirmationModal = false;
    }

    // Cancelar la entrada de stock
    public function cancelStockEntry()
    {
        $this->reset(['products', 'quantities', 'pricessol', 'pricesdolar', 'total_dollar_forsin', 'total_soles_forsin']);
        $this->selectedSupplier = null;
        $this->supplierSearch = "";
        $this->total_dollar = 0;
        $this->total_soles = 0; // Total en soles
        $this->dollar_value = 0; // Valor del dólar
        $this->disableInputs = false;
        session()->flash('message', 'Entrada de stock cancelada.');
    }


    // Buscar proveedores
    public function searchSupplier()
    {
        $this->supplierResults = [];

        if (!empty($this->supplierSearch)) {
            $this->supplierResults = Supplier::where('name', 'like', '%' . $this->supplierSearch . '%')
                ->orWhere('ruc', 'like', '%' . $this->supplierSearch . '%')
                ->orderBy('name', 'asc')
                ->get();
        }
    }
    // Seleccionar proveedor
    public function selectSupplier($id)
    {
        $supplier = Supplier::find($id);

        if ($supplier) {
            $this->selectedSupplier = $supplier;
            $this->supplierSearch = $supplier->name; // Mostrar el nombre del proveedor en el campo de búsqueda
            $this->supplierResults = []; // Limpiar los resultados
        }
    }

    // Buscar productos
    public function searchProduct()
    {
        $this->results = [];

        if (!empty($this->search)) {
            $this->results = Product::where('name', 'like', '%' . $this->search . '%')
                ->orderBy('name', 'asc')
                ->get();

            $this->showlist = $this->results->isNotEmpty();
        } else {
            $this->showlist = false;
        }
    }


    public function getProduct($id)
    {
        $product = Product::find($id);

        if ($product) {

            $this->products[$product->id] = $product;
            $this->quantities[$product->id] = 1; // Inicializar cantidad en 1
            $this->search = ""; // Limpiar el campo de búsqueda
            $this->showlist = false; // Ocultar la lista de resultados

            // Llamar al método adecuado según la moneda seleccionada
            if ($this->currency == 'sol') {
                $this->pricesdolar[$product->id] = 0; // Inicializar precio en 0
                $this->subtotalsol[$product->id] = 0; // Calcular el precio en soles
                $this->subtotaldollar[$product->id] = 0; // Calcular el precio en soles
                $this->pricessol[$product->id] = 0; // Calcular el precio en soles
                $this->calculateTotalSoles(); // Calcular el total en soles
            } else if ($this->currency == 'dolar') {

                $this->pricesdolar[$product->id] = 0; // Inicializar precio en 0
                $this->subtotalsol[$product->id] = 0; // Calcular el precio en soles
                $this->subtotaldollar[$product->id] = 0; // Calcular el precio en soles
                $this->pricessol[$product->id] = 0; // Calcular el precio en soles
                $this->calculateTotals(); // Calcular el total en soles
            }
        }
        $this->updatedProducts();
    }

    public function calculatePriceSol()
    {
        foreach ($this->products as $id => $product) {
            // Validar que el precio en dólares sea numérico y válido
            $price = isset($this->pricesdolar[$id]) && is_numeric($this->pricesdolar[$id])
                ? (float)$this->pricesdolar[$id]
                : 0;

            // Validar que el valor del dólar sea numérico y válido
            $dollarValue = is_numeric($this->dollar_value)
                ? (float)$this->dollar_value
                : 0;

            // Calcular el precio en soles
            $this->pricessol[$id] = $price * $dollarValue;
        }
    }



    public function calculateSubtotalSol()
    {
        $this->subtotalsol = [];

        foreach ($this->products as $id => $product) {
            // Verificar que los valores sean numéricos y válidos
            $price = isset($this->pricessol[$id]) && is_numeric($this->pricessol[$id])
                ? (float)$this->pricessol[$id]
                : 0;

            $quantity = isset($this->quantities[$id]) && is_numeric($this->quantities[$id])
                ? (int)$this->quantities[$id]
                : 0;

            // Calcular subtotal en soles
            $this->subtotalsol[$id] = $price * $quantity;
        }
    }

    public function calculateSubtotalDollar()
    {
        $this->subtotaldollar = [];

        foreach ($this->products as $id => $product) {
            // Verificar que los valores sean numéricos y válidos
            $price = isset($this->pricesdolar[$id]) && is_numeric($this->pricesdolar[$id])
                ? (float)$this->pricesdolar[$id]
                : 0;

            $quantity = isset($this->quantities[$id]) && is_numeric($this->quantities[$id])
                ? (int)$this->quantities[$id]
                : 0;

            // Calcular subtotal en dólares
            $this->subtotaldollar[$id] = $price * $quantity;
        }
    }


    public function calculateOperationsDolar()
    {
        $this->calculatePriceSol();
        $this->calculateSubtotalSol();
        $this->calculateSubtotalDollar();
        $this->calculateTotals();
    }
    public function calculateOperationsSol()
    {
        $this->calculateSubtotalSol();
        $this->calculateTotalSoles();
    }


    public function calculateTotalDollar()
    {
        $this->total_dollar_forsin = 0;

        foreach ($this->products as $id => $product) {
            // Verificar que los valores sean numéricos y válidos
            $price = isset($this->pricesdolar[$id]) && is_numeric($this->pricesdolar[$id])
                ? (float)$this->pricesdolar[$id]
                : 0;

            $quantity = isset($this->quantities[$id]) && is_numeric($this->quantities[$id])
                ? (int)$this->quantities[$id]
                : 0;

            // Calcular subtotal en dólares
            $this->total_dollar_forsin += $price * $quantity;
        }
    }

    public function calculateTotalSoles()
    {
        $this->total_soles_forsin = 0;

        foreach ($this->products as $id => $product) {
            // Verificar que los valores sean numéricos y válidos
            $price = isset($this->pricessol[$id]) && is_numeric($this->pricessol[$id])
                ? (float)$this->pricessol[$id]
                : 0;

            $quantity = isset($this->quantities[$id]) && is_numeric($this->quantities[$id])
                ? (int)$this->quantities[$id]
                : 0;

            // Calcular subtotal en soles
            $this->total_soles_forsin += $price * $quantity;
        }
    }
    public function calculateTotals()
    {
        $this->calculateTotalDollar();
        $this->calculateTotalSoles();
    }


    // Eliminar un producto de la entrada de stock
    public function removeProduct($id)
    {
        unset($this->products[$id]); // Eliminar el producto
        unset($this->quantities[$id]); // Eliminar la cantidad
        unset($this->pricessol[$id]); // Eliminar el precio
        unset($this->pricesdolar[$id]); // Eliminar el precio en dólares

        $this->calculateTotals();
        $this->updatedProducts();
    }



    public function saveStockEntry()
    {

        // Validaciones de campos obligatorios
        if (!$this->selectedSupplier) {
            $this->validationMessage = 'Por favor, selecciona un proveedor antes de guardar la entrada.';
            $this->showConfirmationModal = true;
            return;
        }

        if (empty($this->products)) {
            $this->validationMessage = 'Por favor, agrega al menos un producto antes de guardar la entrada.';
            $this->showConfirmationModal = true;
            return;
        }

        $this->reception_date = $this->reception_date ?? now(); // Usa la fecha actual si es null

        // Validar que todas las cantidades y precios sean válidos
        foreach ($this->products as $product) {
            $quantity = $this->quantities[$product->id] ?? 0;
            $pricesol = $this->pricessol[$product->id] ?? 0;
            $pricedolar = $this->pricesdolar[$product->id] ?? 0;

            // Validar cantidad mayor a 0
            if ($quantity <= 0) {
                $this->validationMessage = "La cantidad para el producto '{$product->name}' debe ser mayor a 0.";
                $this->showConfirmationModal = true;
                return;
            }

            // Validar precios según la moneda
            if ($this->currency === 'sol' && $pricesol <= 0) {
                $this->validationMessage = "El precio en soles para el producto '{$product->name}' debe ser mayor a 0.";
                $this->showConfirmationModal = true;
                return;
            }

            if ($this->currency === 'dolar' && $pricedolar <= 0) {
                $this->validationMessage = "El precio en dólares para el producto '{$product->name}' debe ser mayor a 0.";
                $this->showConfirmationModal = true;
                return;
            }
        }
        // Validar que los totales coincidan
        if ($this->total_dollar_forsin != $this->total_dollar) {
            $this->validationMessage = 'Los totales en dólares no coinciden.';
            $this->showConfirmationModal = true;
            return;
        }

        if ($this->total_soles_forsin != $this->total_soles) {
            $this->validationMessage = 'Los totales en soles no coinciden.';
            $this->showConfirmationModal = true;
            return;
        }

        // Crear la entrada de stock
        $stockEntry = StockEntry::create([
            'supplier_id' => $this->selectedSupplier->id,
            'user_id' => auth()->id(),
            'reception_date' => $this->reception_date,
            'total_dollar' => $this->total_dollar_forsin, // Usar el total calculado en dólares
            'currency' => $this->currency,
            'dollar_value' => $this->dollar_value,
            'total_soles' => $this->total_soles_forsin, // Usar el total calculado en soles
        ]);

        // Agregar los detalles de la entrada de stock
        foreach ($this->products as $product) {
            $quantity = $this->quantities[$product->id];

            // Obtener los precios en dólar y soles
            $pricedolar = $this->pricesdolar[$product->id];
            $pricesol = $this->pricessol[$product->id];

            // Usar los subtotales ya calculados en las propiedades
            $subtotalDollar = $this->subtotaldollar[$product->id];
            $subtotalSol = $this->subtotalsol[$product->id];

            // Crear el detalle de la entrada de stock
            $stockEntryDetail = $stockEntry->stockEntryDetails()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'purchase_pricedolar' => $pricedolar,
                'purchase_pricesol' => $pricesol,
                'subtotaldolar' => $subtotalDollar,
                'subtotalsol' => $subtotalSol,
            ]);

            // Incrementar el stock del producto basado en la cantidad de la entrada de stock
            $product->increment('stock', $quantity);
            // Cambiar el precio de compra del producto por el precio del detalle de stock en soles
            $product->purchase_price = $pricesol;
            // Guardar el cambio en el producto
            $product->save(); // Esto es lo que faltaba para persistir el cambio en la base de datos
        }


        // Resetear los valores del formulario después de guardar
        $this->reset([
            'products',
            'quantities',
            'pricesdolar',
            'pricessol',
            'total_dollar_forsin',
            'total_soles_forsin'
        ]);
        $this->selectedSupplier = null;
        $this->supplierSearch = "";
        $this->showConfirmationModal = false;
        $this->total_dollar = 0;
        $this->total_soles = 0;
        $this->dollar_value = 0;
        $this->updatedProducts();

        // Mostrar mensaje de éxito
        session()->flash('message', 'Entrada de stock guardada exitosamente.');
    }


    public function render()
    {
        return view('livewire.stock-entry-component')->layout('layouts.app');
    }
}
