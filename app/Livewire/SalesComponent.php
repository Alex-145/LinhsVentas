<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Client;
use App\Models\Sale;
use App\Models\Service;
use Livewire\Component;

class SalesComponent extends Component
{
    public $menuAbierto = true;
    public $showlist = false, $serviceshowlist = false;

    // Búsqueda
    public $search = "";
    public $servicobuscar = "";

    // Resultados de búsqueda
    public $resultsProduct = [];
    public $resultsService = [];

    // Productos
    public $products = [];
    public $productQuantities = [];
    public $productPrices = [];

    // Servicios
    public $services = [];
    public $serviceQuantities = [];
    public $servicePrices = [];

    // Totales y cliente
    public $total = 0;
    public $clientSearch = "";
    public $clientResults = [];
    public $selectedClient = null;

    // Estado y mensajes
    public $status_fac = 'no_aplicable';
    public $showConfirmationModal = false;
    public $validationMessage = '';


    protected $listeners = ['toggleMenu' => 'updateMenuState'];

    public function updateMenuState()
    {
        $this->menuAbierto = !$this->menuAbierto;
    }

    public function openConfirmationModal()
    {
        $this->validationMessage = ''; // Limpiar el mensaje previo
        $this->showConfirmationModal = true; // Mostrar el modal
    }

    public function closeConfirmationModal()
    {
        $this->showConfirmationModal = false;
    }

    public function cancelSale()
    {
        $this->reset([
            'products',
            'productQuantities',
            'productPrices',
            'services',
            'serviceQuantities',
            'servicePrices',
            'total',
            'status_fac'
        ]);
        $this->selectedClient = null;
        $this->clientSearch = "";
        session()->flash('message', 'Venta cancelada.');
    }

    // Método para buscar productos
    public function searchProduct()
    {
        $this->resultsProduct = [];

        if (!empty($this->search)) {
            $this->resultsProduct = Product::where('name', 'like', '%' . $this->search . '%')
                ->orderBy('name', 'asc')
                ->get();

            $this->showlist = $this->resultsProduct->isNotEmpty();
        } else {
            $this->showlist = false;
        }
    }

    // Método para buscar servicios
    public function searchService()
    {
        $this->resultsService = [];

        if (!empty($this->servicobuscar)) {
            $this->resultsService = Service::where('name', 'like', '%' . $this->servicobuscar . '%')
                ->orderBy('name', 'asc')
                ->get();

            $this->serviceshowlist = $this->resultsService->isNotEmpty();
        } else {
            $this->serviceshowlist = false;
        }
    }

    // Método para buscar clientes
    public function searchClient()
    {
        $this->clientResults = [];

        if (!empty($this->clientSearch)) {
            $this->clientResults = Client::where('name', 'like', '%' . $this->clientSearch . '%')
                ->orWhere('dni_ruc', 'like', '%' . $this->clientSearch . '%')
                ->orWhere('business_name', 'like', '%' . $this->clientSearch . '%')
                ->orderBy('name', 'asc')
                ->get();
        }
    }

    // Método para seleccionar un cliente
    public function selectClient($id)
    {
        $client = Client::find($id);

        if ($client) {
            $this->selectedClient = $client;
            $this->clientSearch = $client->name; // Mostrar el nombre del cliente en el campo de búsqueda
            $this->clientResults = []; // Limpiar los resultados
        }
    }

    // Método para agregar un producto
    public function getProduct($id)
    {
        $product = Product::find($id);

        if ($product) {
            if (isset($this->products[$product->id])) {
                $this->productQuantities[$product->id]++;
            } else {
                $this->products[$product->id] = $product;
                $this->productQuantities[$product->id] = 1;
                $this->productPrices[$product->id] = $product->sale_price;
            }

            $this->search = "";
            $this->showlist = false;
            $this->calculateTotal();
        }
    }

    // Método para agregar un servicio
    public function getService($id)
    {
        $service = Service::find($id);

        if ($service) {
            if (isset($this->services[$service->id])) {
                $this->serviceQuantities[$service->id]++;
            } else {
                $this->services[$service->id] = $service;
                $this->serviceQuantities[$service->id] = 1;
                $this->servicePrices[$service->id] = $service->price;
            }

            $this->servicobuscar = "";
            $this->serviceshowlist = false;
            $this->calculateTotal();
        }
    }

    // Método para eliminar un producto o servicio de la venta
    public function removeProduct($id)
    {
        unset($this->products[$id]);
        unset($this->productQuantities[$id]);
        unset($this->productPrices[$id]);
        $this->calculateTotal();
    }

    public function removeService($id)
    {
        unset($this->services[$id]);
        unset($this->serviceQuantities[$id]);
        unset($this->servicePrices[$id]);
        $this->calculateTotal();
    }

    // Método para calcular
    public function calculateTotal()
{
    $this->total = 0;

    foreach ($this->products as $id => $product) {
        $price = (float) ($this->productPrices[$id] ?? $product->sale_price);
        $quantity = (int) ($this->productQuantities[$id] ?? 0);

        // Asegurar que price y quantity son valores numéricos
        if ($price && $quantity >= 0) {
            $this->total += $price * $quantity;
        }
    }

    foreach ($this->services as $id => $service) {
        $price = (float) ($this->servicePrices[$id] ?? $service->price);
        $quantity = (int) ($this->serviceQuantities[$id] ?? 0);

        // Asegurar que price y quantity son valores numéricos
        if ($price && $quantity >= 0) {
            $this->total += $price * $quantity;
        }
    }
}

public function calculateProductUtilidad($product)
{
    $quantity = (int) ($this->productQuantities[$product->id] ?? 0);
    $price = (float) ($this->productPrices[$product->id] ?? 0);
    $utilidadSaleDetail = 0;

    if ($product instanceof Product) {
        $purchasePrice = (float) ($product->purchase_price ?? 0);

        // Verificar que price, purchasePrice y quantity son numéricos antes de calcular
        if ($price && $purchasePrice && $quantity >= 0) {
            $utilidadSaleDetail = ($price - $purchasePrice) * $quantity;
        }
    }

    return $utilidadSaleDetail;
}

public function calculateServiceUtilidad($service)
{
    $quantity = (int) ($this->serviceQuantities[$service->id] ?? 0);
    $price = (float) ($this->servicePrices[$service->id] ?? 0);
    $utilidadSaleDetail = 0;

    if ($service instanceof Service) {
        // Verificar que el precio y la cantidad son numéricos antes de calcular
        if ($price && $quantity >= 0) {
            $utilidadSaleDetail = $price * $quantity;
        }
    }

    return $utilidadSaleDetail;
}

public function calculateUtilidadSale()
{
    $utilidadSale = 0;

    // Calcular utilidad de productos
    foreach ($this->products as $product) {
        $quantity = (int) ($this->productQuantities[$product->id] ?? 0);
        $price = (float) ($this->productPrices[$product->id] ?? 0);

        if ($product instanceof Product) {
            $purchasePrice = (float) ($product->purchase_price ?? 0);

            // Verificar que price, purchasePrice y quantity son numéricos antes de calcular
            if ($price && $purchasePrice && $quantity >= 0) {
                $utilidadSale += ($price - $purchasePrice) * $quantity;
            }
        }
    }

    // Calcular utilidad de servicios
    foreach ($this->services as $service) {
        $quantity = (int) ($this->serviceQuantities[$service->id] ?? 0);
        $price = (float) ($this->servicePrices[$service->id] ?? 0);

        if ($service instanceof Service) {
            // Verificar que price y quantity son numéricos antes de calcular
            if ($price && $quantity >= 0) {
                $utilidadSale += $price * $quantity;
            }
        }
    }

    return $utilidadSale;
}




    public function saveSale()
    {
        // Validar que haya un cliente seleccionado
        if (!$this->selectedClient) {
            $this->validationMessage = 'Por favor, selecciona un cliente antes de guardar la venta.';
            $this->showConfirmationModal = true; // Mostrar el modal con el mensaje
            return;
        }

        // Validar que haya productos o servicios seleccionados
        if (empty($this->products) && empty($this->services)) {
            $this->validationMessage = 'Por favor, agrega al menos un producto o servicio antes de guardar la venta.';
            $this->showConfirmationModal = true; // Mostrar el modal con el mensaje
            return;
        }

        // Validar que el total sea mayor a 0
        if ($this->total <= 0) {
            $this->validationMessage = 'El total de la venta no puede ser cero.';
            $this->showConfirmationModal = true; // Mostrar el modal con el mensaje
            return;
        }

        // Crear la venta
        $sale = Sale::create([
            'client_id' => $this->selectedClient->id,
            'user_id' => auth()->id(),
            'sale_date' => now(),
            'total' => $this->total,
            'status_fac' => $this->status_fac,
            'estado_sale' => 'habil_sale',
            'utilidad_sale' => $this->calculateUtilidadSale(), // Asignar la utilidad calculada
        ]);


        // Guardar los detalles de los productos
        foreach ($this->products as $product) {
            $quantity = $this->productQuantities[$product->id];
            $price = $this->productPrices[$product->id];
            $utilidadSaleDetail = $this->calculateProductUtilidad($product); // Calcular la utilidad para el producto

            $sale->saleDetails()->create([
                'salable_type' => get_class($product),
                'salable_id' => $product->id,
                'quantity' => $quantity,
                'price' => $price,
                'subtotal' => ($price * $quantity),
                'estado_detail' => 'habil_detail',
                'utilidad_saledetail' => $utilidadSaleDetail, // Asignar la utilidad calculada para el producto
            ]);

            // Actualizar el stock si es un producto
            if ($product instanceof Product) {
                $product->decrement('stock', $quantity);
            }
        }

        // Guardar los detalles de los servicios
        foreach ($this->services as $service) {
            $quantity = $this->serviceQuantities[$service->id];
            $price = $this->servicePrices[$service->id];
            $utilidadSaleDetail = $this->calculateServiceUtilidad($service); // Calcular la utilidad para el servicio

            $sale->saleDetails()->create([
                'salable_type' => get_class($service),
                'salable_id' => $service->id,
                'quantity' => $quantity,
                'price' => $price,
                'subtotal' => ($price * $quantity),
                'estado_detail' => 'habil_detail',
                'utilidad_saledetail' => $utilidadSaleDetail, // Asignar la utilidad calculada para el servicio
            ]);
        }


        // Limpiar los campos después de guardar
        $this->reset([
            'products',
            'productQuantities',
            'productPrices',
            'services',
            'serviceQuantities',
            'servicePrices',
            'total',
            'status_fac'
        ]);
        $this->selectedClient = null;
        $this->clientSearch = "";
        $this->showConfirmationModal = false;

        session()->flash('message', 'Venta guardada exitosamente.');
    }


    public function render()
    {
        return view('livewire.sales-component')->layout('layouts.app');
    }
}
