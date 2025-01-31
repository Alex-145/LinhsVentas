<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Livewire\Component;
use Livewire\WithPagination;

class SalesList extends Component
{
    use WithPagination; // Incluir el trait

    public $search = '';  // Propiedad para almacenar la búsqueda por nombre de cliente
    public $menuAbierto = true;
    public $sales;
    public $selectedSale = null;
    public $showDeleteConfirmation = false;
    public $saleToDelete = null;
    public $startDate;
    public $endDate;
    public $tithe = 0;
    public $showStatusChangeConfirmation = false;
    public $saleIdToChangeStatus = null;
    public $isOpen = false;
    public $newStatus; // Property to hold the new status
    public $detailToDelete = null;
    public $showDeleteConfirmationde = false;
    public $selectedClient = null;
    public $filterFacturado = false; // Por defecto, el filtro está desactivado
    public $filterPendienteFacturacion = false; // Por defecto, el filtro está desactivado
    public $filterNoAplicable = false; // Por defecto, el filtro está desactivado
    public $isPendienteFacturacion = false; // Agregar una propiedad para controlar el filtro


    protected $listeners = ['toggleMenu' => 'updateMenuState'];

    public function confirmDeleteDetail($detailId)
    {
        $this->detailToDelete = $detailId;
        $this->showDeleteConfirmationde = true;
    }
    public function mount()
    {
        $this->isPendienteFacturacion = session()->get('isPendienteFacturacion', false);

        if ($this->isPendienteFacturacion) {
            $this->allfacpendiente();
        } else {
            $this->loadSales();
        }
    }

    public function loadSales()
    {
        $query = Sale::with(['client', 'user', 'saleDetails' => function ($query) {
            $query->where('estado_detail', '!=', 'anulado_detail'); // Excluir detalles anulados
        }])
            ->where('estado_sale', 'habil_sale') // Solo ventas habilitadas
            ->orderBy('created_at', 'desc');

        // Si no hay filtros de fecha, mostramos solo las ventas del día
        if (!$this->startDate && !$this->endDate) {
            $query->whereDate('sale_date', now()->toDateString());
        }

        // Filtro por búsqueda
        if ($this->search) {
            $query->whereHas('client', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });
        }

        // Si hay filtros de fecha, aplicamos el filtro entre el rango de fechas
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('sale_date', [$this->startDate, $this->endDate]);
        }

        // Combinar filtros de 'facturado', 'pendiente de facturación' y 'no aplicable' si están activados
        $statuses = [];
        if ($this->filterFacturado) {
            $statuses[] = 'facturado';
        }
        if ($this->filterPendienteFacturacion) {
            $statuses[] = 'pendiente_facturacion';
        }
        if ($this->filterNoAplicable) {
            $statuses[] = 'no_aplicable';
        }
        if (!empty($statuses)) {
            $query->whereIn('status_fac', $statuses);
        }

        $this->sales = $query->get();
    }


    public function allfacpendiente()
    {
        $query = Sale::with(['client', 'user', 'saleDetails' => function ($query) {
            $query->where('estado_detail', '!=', 'anulado_detail'); // Excluir detalles anulados
        }])
            ->where('estado_sale', 'habil_sale') // Solo ventas habilitadas
            ->where('status_fac', 'pendiente_facturacion') // Solo ventas pendientes de facturación
            ->orderBy('created_at', 'desc');

        // Filtro por búsqueda
        if ($this->search) {
            $query->whereHas('client', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });
        }

        // Sin filtros de fecha, mostramos todas las ventas
        $this->sales = $query->get();


    }



    public function updateMenuState()
    {
        $this->menuAbierto = !$this->menuAbierto;
    }
    public function updateSaleStatus($saleId, $newStatus, $requiredCurrentStatus)
    {
        $sale = Sale::find($saleId);

        if ($sale && $sale->status_fac === $requiredCurrentStatus) {
            $sale->update(['status_fac' => $newStatus]);
            session()->flash('message', "El estado de la venta se actualizó a {$newStatus}.");
        } else {
            session()->flash('error', 'No se pudo actualizar el estado de la venta.');
        }
    }
    public function selectSale($saleId)
    {
        $this->selectedSale = $this->selectedSale === $saleId ? null : $saleId;
    }
    public function confirmDelete($saleId)
    {
        $this->saleToDelete = $saleId;
        $this->showDeleteConfirmation = true;
    }
    public function deleteSale()
    {
        if ($this->saleToDelete) {
            $sale = Sale::with('saleDetails.salable')->find($this->saleToDelete);

            if ($sale) {
                // Cambiar el estado de la venta a anulado_sale
                $sale->update(['estado_sale' => 'anulado_sale']);

                // Cambiar el estado de cada detalle asociado a anulado_detail
                foreach ($sale->saleDetails as $detail) {
                    $detail->update(['estado_detail' => 'anulado_detail']);

                    // Verificar si el detalle es un producto y recalcular el stock
                    $product = $detail->salable; // Usa salable en lugar de product

                    // Comprobar si el salable es un producto (tiene la columna stock)
                    if ($product instanceof Product) {
                        $product->increment('stock', $detail->quantity);
                    }
                }

                session()->flash('message', 'La venta y sus detalles han sido anulados exitosamente.');
            } else {
                session()->flash('error', 'No se pudo encontrar la venta.');
            }

            // Restablecer las propiedades
            $this->showDeleteConfirmation = false;
            $this->saleToDelete = null;
            $this->loadSales();
        }
    }
    public function deleteDetailSale($detailId = null)
    {
        $detailId = $detailId ?? $this->detailToDelete;
        $detail = SaleDetail::with('salable', 'sale')->find($detailId);

        if ($detail) {
            $sale = $detail->sale;

            // Actualiza el estado del detalle a "anulado_detail"
            $detail->update(['estado_detail' => 'anulado_detail']);

            // Devuelve el stock si aplica
            $salable = $detail->salable;
            if ($salable instanceof Product) {
                $salable->increment('stock', $detail->quantity);
            }

            // Recalcular el total y la utilidad de la venta
            $newTotal = $sale->total - $detail->subtotal;
            $newUtilidad = $sale->utilidad_sale - $detail->utilidad_saledetail;

            $remainingDetails = $sale->saleDetails->where('estado_detail', '!=', 'anulado_detail');
            if ($remainingDetails->isEmpty()) {
                // Si no hay detalles activos, anula la venta
                $sale->update([
                    'estado_sale' => 'anulado_sale',
                    'total' => 0,
                    'utilidad_sale' => 0,
                ]);
            } else {
                // Actualiza el total y la utilidad de la venta
                $sale->update([
                    'total' => $newTotal,
                    'utilidad_sale' => $newUtilidad,
                ]);
            }

            session()->flash('message', 'El detalle ha sido anulado exitosamente.');
        } else {
            session()->flash('error', 'No se pudo encontrar el detalle.');
        }

        $this->showDeleteConfirmationde = false;
        $this->detailToDelete = null;
        $this->loadSales();
    }
    public function filterByDate()
    {
        $this->loadSales();
    }
    public function calculateTithe()
    {
        $totalGains = $this->calculateTotalGains();
        $this->tithe = $totalGains * 0.10;
    }
    public function confirmStatusChange($saleId, $newStatus)
    {
        $this->saleIdToChangeStatus = $saleId;
        $this->newStatus = $newStatus;
        $this->showStatusChangeConfirmation = true;
    }
    public function openModal()
    {
        $this->isOpen = !$this->isOpen;
    }
    public function changeStatus()
    {
        if ($this->saleIdToChangeStatus) {
            $sale = Sale::find($this->saleIdToChangeStatus);

            if ($sale) {
                // Verificamos si el estado actual es 'no_aplicable' y lo cambiamos a 'factura_pendiente'
                if ($sale->status_fac === 'no_aplicable') {
                    $sale->update(['status_fac' => 'pendiente_facturacion']);
                    session()->flash('message', "El estado de la venta se actualizó a pendiente_facturacion.");
                }
                // Verificamos si el estado actual es 'factura_pendiente' y lo cambiamos a 'facturado'
                elseif ($sale->status_fac === 'pendiente_facturacion') {
                    $sale->update(['status_fac' => 'facturado']);
                    session()->flash('message', "El estado de la venta se actualizó a facturado.");
                } else {
                    // Si no está en los estados que queremos cambiar, mostramos un error
                    session()->flash('error', 'El estado de la venta no es válido para actualizar.');
                    return;
                }

                // Recargamos las ventas (si es necesario)
                $this->loadSales();
            } else {
                session()->flash('error', 'No se pudo encontrar la venta.');
            }

            // Restablecer las propiedades después de la actualización
            $this->showStatusChangeConfirmation = false;
            $this->saleIdToChangeStatus = null;
            $this->newStatus = null;
        }
    }
    public function filterThisWeek()
    {
        $this->startDate = now()->startOfWeek(\Carbon\Carbon::SUNDAY); // Domingo como inicio de semana
        $this->endDate = now()->endOfWeek(\Carbon\Carbon::SATURDAY); // Sábado como fin de semana
        $this->loadSales();
    }
    public function filterThisMonth()
    {
        $this->startDate = now()->startOfMonth();
        $this->endDate = now()->endOfMonth();
        $this->loadSales();
    }
    public function cancelAction()
    {
        $this->showDeleteConfirmation = false;
        $this->saleToDelete = null;
        $this->showStatusChangeConfirmation = false;
        $this->saleIdToChangeStatus = null;
    }
    public function calculateTotalGains()
    {
        $totalGains = $this->sales->sum('utilidad_sale');
        return $totalGains;
    }
    public function calculateTotalSales()
    {
        $totalSales = $this->sales->sum('total');
        return $totalSales;
    }
    public function showClientInfo($saleId)
    {
        $sale = Sale::with('client')->find($saleId);

        if ($sale) {
            $client = $sale->client;
            $this->selectedClient = [
                'name' => $client->name,
                'dni_ruc' => $client->dni_ruc,
                'business_name' => $client->business_name,
                'phone_number' => $client->phone_number,
            ];
            session()->flash('clientInfo', $this->selectedClient);
        } else {
            session()->flash('error', 'No se pudo encontrar la venta.');
        }
    }


    // ----pdf----

    public function generateSalePdf($saleId)
    {
        $sale = Sale::with(['client', 'saleDetails' => function ($query) {
            $query->where('estado_detail', '!=', 'anulado_detail'); // Excluir detalles anulados
        }])->find($saleId);

        if (!$sale) {
            session()->flash('error', 'No se encontró la venta.');
            return;
        }

        // Genera el PDF
        $pdf = Pdf::loadView('pdf.sale', ['sale' => $sale]);

        // Forzar la descarga del PDF
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream(); // Enviar el PDF como respuesta
        }, 'name.pdf');
    }


    public function render()
    {
        if ($this->isPendienteFacturacion) {
            $this->allfacpendiente(); // Llamar allfacpendiente si el estado es true
        } else {
            $this->loadSales(); // Llamar loadSales si el estado es false
        }

        \Carbon\Carbon::setLocale('es');
        return view('livewire.sales-list', [
            'sales' => $this->sales,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'totalGains' => $this->calculateTotalGains(),
            'totalSales' => $this->calculateTotalSales(), // Pasamos el total de ventas
        ])->layout('layouts.app');
    }
}
