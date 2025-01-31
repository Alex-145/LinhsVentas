<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\StockEntry;
use App\Models\StockEntryDetail;
use Livewire\Component;
use Livewire\WithPagination;

class StockEntryList extends Component
{
    use WithPagination; // Incluir el trait para habilitar la paginación en el componente

    public $search = '';  // Propiedad para almacenar la búsqueda por nombre de cliente
    public $menuAbierto = true; // Controla el estado de un menú (abierto o cerrado)
    public $stockEntries; // Almacena las ventas cargadas
    public $selectedStockEntry = null; // Almacena la venta seleccionada
    public $showDeleteConfirmation = false; // Controla si se muestra la confirmación de eliminación
    public $stockEntryToDelete = null; // Almacena el ID de la venta a eliminar
    public $startDate; // Fecha de inicio para el filtro
    public $endDate; // Fecha de fin para el filtro
    public $isOpen = false; // Controla si un modal está abierto o cerrado
    public $detailToDelete = null; // Detalle de la venta a eliminar
    public $showDeleteConfirmationde = false; // Controla la confirmación para eliminar un detalle
    public $selectedSupplier = null; // Almacena el cliente seleccionado
    protected $listeners = ['toggleMenu' => 'updateMenuState']; // Escucha eventos de Livewire


    // Monta el componente cargando las ventas al iniciar
    public function mount()
    {
        $this->loadStockEntries();
    }


    public function loadStockEntries()
    {
        $query = StockEntry::with(['supplier', 'user', 'stockEntryDetails' => function ($query) {
            // Filtrar detalles de las entradas de stock según algún criterio, si es necesario
            $query->where('quantity', '>', 0); // Solo entradas con cantidad mayor a cero (puedes modificar esto)
        }])
            ->orderBy('created_at', 'desc'); // Ordenar por fecha descendente

        // Si no hay filtros de fecha, mostramos solo las entradas de stock del día
        if (!$this->startDate && !$this->endDate) {
            $query->whereDate('reception_date', now()->toDateString());
        }

        // Filtro por búsqueda de proveedor
        if ($this->search) {
            $query->whereHas('supplier', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });
        }

        // Filtro por rango de fechas
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('reception_date', [$this->startDate, $this->endDate]);
        }

        // Ejecuta la consulta y almacena los resultados
        $this->stockEntries = $query->get();
    }


    // Actualiza el estado del menú (abre/cierra)
    public function updateMenuState()
    {
        $this->menuAbierto = !$this->menuAbierto;
    }


    public function selectStockEntry($stockEntryId)
    {
        $this->selectedStockEntry = $this->selectedStockEntry === $stockEntryId ? null : $stockEntryId;
    }

    // Confirma la eliminación de una entrada de stock
    public function confirmDelete($stockEntryId)
    {
        $this->stockEntryToDelete = $stockEntryId;
        $this->showDeleteConfirmation = true;
    }


    // Elimina una entrada de stock y actualiza el stock del producto
    public function deleteStockEntry()
    {
        if ($this->stockEntryToDelete) {
            $stockEntry = StockEntry::with('stockEntryDetails.product')->find($this->stockEntryToDelete);

            if ($stockEntry) {
                // Eliminar la entrada de stock
                $stockEntry->delete();

                // Restaurar el stock de los productos asociados
                foreach ($stockEntry->stockEntryDetails as $detail) {
                    // Verificar si el detalle está asociado a un producto
                    $product = $detail->product; // Obtén el producto desde el detalle

                    if ($product instanceof Product) {
                        // Aumentar el stock del producto según la cantidad del detalle
                        $product->decrement('stock', $detail->quantity);
                    }
                }

                session()->flash('message', 'La entrada de stock y sus detalles han sido eliminados exitosamente.');
            } else {
                session()->flash('error', 'No se pudo encontrar la entrada de stock.');
            }

            // Restablecer las propiedades
            $this->showDeleteConfirmation = false;
            $this->stockEntryToDelete = null;
            $this->loadStockEntries();
        }
    }


    // Elimina un detalle de la entrada de stock
    public function deleteDetailStockEntry($detailId = null)
    {
        $detailId = $detailId ?? $this->detailToDelete;
        $detail = StockEntryDetail::with('product', 'stockEntry')->find($detailId);

        if ($detail) {
            $stockEntry = $detail->stockEntry;

            // Elimina el detalle de la entrada de stock
            $detail->delete();

            // Restar la cantidad al producto si la entrada de stock se elimina
            $product = $detail->product;
            if ($product instanceof Product) {
                $product->decrement('stock', $detail->quantity); // Restar la cantidad
            }

            // Recalcular el total de la entrada de stock
            $newTotalDolar = $stockEntry->total_dollar - $detail->subtotaldolar;
            $newTotalSoles = $stockEntry->total_soles - $detail->subtotalsol;

            // Verificar si la entrada de stock tiene más detalles
            $remainingDetails = $stockEntry->stockEntryDetails->where('estado_detail', '!=', 'anulado_detail');

            // Si no quedan detalles, eliminar la entrada de stock
            if ($remainingDetails->isEmpty()) {
                // Eliminar la entrada de stock si es el último detalle
                $stockEntry->delete();
            } else {
                // Si quedan detalles, actualizar la entrada de stock
                $stockEntry->update([
                    'total_dollar' => $newTotalDolar,
                    'total_soles' => $newTotalSoles,
                ]);
            }

            session()->flash('message', 'El detalle de la entrada de stock ha sido eliminado exitosamente.');
        } else {
            session()->flash('error', 'No se pudo encontrar el detalle.');
        }

        // Restablecer las propiedades
        $this->showDeleteConfirmationde = false;
        $this->detailToDelete = null;
        $this->loadStockEntries();
    }

    // Confirma la eliminación de un detalle
    public function confirmDeleteDetail($detailId)
    {
        $this->detailToDelete = $detailId;
        $this->showDeleteConfirmationde = true;
    }



    // Filtra las ventas por fecha (inicio y fin)
    public function filterByDate()
    {
        $this->loadStockEntries();
    }

    // Abre o cierra un modal
    public function openModal()
    {
        $this->isOpen = !$this->isOpen;
    }

    // Filtra las ventas por esta semana
    public function filterThisWeek()
    {
        $this->startDate = now()->startOfWeek(\Carbon\Carbon::SUNDAY);
        $this->endDate = now()->endOfWeek(\Carbon\Carbon::SATURDAY);
        $this->loadStockEntries();
    }

    // Filtra las ventas por este mes
    public function filterThisMonth()
    {
        $this->startDate = now()->startOfMonth();
        $this->endDate = now()->endOfMonth();
        $this->loadStockEntries();
    }

    // Cancela cualquier acción pendiente
    public function cancelAction()
    {
        $this->showDeleteConfirmation = false;
        $this->stockEntryToDelete = null;
    }

    // Calcula los gastos totales en soles si la moneda es 'sol'
    public function calculateTotalExpenses()
    {
        $totalExpenses = $this->stockEntries->sum(function ($stockEntry) {
            // Verifica si la moneda es "sol" y calcula el total en soles
            if ($stockEntry->currency === 'sol') {
                return $stockEntry->total_soles;
            }

            // Si la moneda no es "sol", no calculamos en soles, por ejemplo, en dólares
            return 0;
        });

        return $totalExpenses;
    }


    // Calcula los gastos totales en dólares si la moneda es 'dollar'
    public function calculateTotalExpensesInDollars()
    {
        $totalExpensesInDollars = $this->stockEntries->sum(function ($stockEntry) {
            // Verifica si la moneda es "dollar" y calcula el total en dólares
            if ($stockEntry->currency === 'dolar') {
                return $stockEntry->total_dollar;
            }

            // Si la moneda no es "dollar", no calculamos en dólares
            return 0;
        });

        return $totalExpensesInDollars;
    }


    // Muestra la información del proveedor
    public function showSupplierInfo($stockEntryId)
    {
        $stockEntry = StockEntry::with('supplier')->find($stockEntryId);

        if ($stockEntry) {
            $supplier = $stockEntry->supplier;
            $this->selectedSupplier = [
                'name' => $supplier->name,
                'cellphone' => $supplier->cellphone,
                'ruc' => $supplier->ruc,
            ];
            session()->flash('supplierInfo', $this->selectedSupplier);
        } else {
            session()->flash('error', 'No se pudo encontrar la entrada de stock.');
        }
    }



    // Renderiza la vista de Livewire
    // Renderiza la vista de Livewire
    public function render()
    {
        $this->loadStockEntries(); // Carga las ventas
        \Carbon\Carbon::setLocale('es'); // Configura el idioma de Carbon

        return view('livewire.stock-entry-list', [
            'stockEntries' => $this->stockEntries,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'totalExpensesInDollars' => $this->calculateTotalExpensesInDollars(), // Total de gastos en dólares
            'totalExpenses' => $this->calculateTotalExpenses(), // Total de gastos en soles
        ])->layout('layouts.app'); // Retorna la vista con el layout
    }
}
