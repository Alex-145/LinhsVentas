<?php

namespace App\Livewire;

use App\Mail\PagoAprobadoCliente;
use App\Models\Client;
use App\Models\Product;
use App\Models\Proforma;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class VentasOnline extends Component
{
    use WithPagination, WithFileUploads;

    public $menuAbierto = true;
    public $proformaSeleccionada = null;
    public $comprobantes = [];
    public $accion = '';
    public $motivoRechazo = '';
    public $filtroEstado = 'todos';
    public $modalComprobantesAbierto = false;
    public $modalDetallesAbierto = false;
    public $metodo_pago = '';


    protected $paginationTheme = 'tailwind';

    protected $listeners = [
        'toggleMenu' => 'updateMenuState',
        'ver-detalles' => 'verDetalles',
    ];

    public $opcionesEstado = [
        'todos' => 'Todos',
        'solocotizacion' => 'Solo Cotización',
        'esperando_pago' => 'Esperando Pago',
        'esperando_verificacion' => 'Esperando Verificación',
        'pagado' => 'Pagado',
        'cerrado' => 'Cerrado',
        'cerrado_por_vencimiento' => 'Cerrado por Vencimiento',
        'cancelado' => 'Cancelado',
    ];

    public function updateMenuState()
    {
        $this->menuAbierto = !$this->menuAbierto;
    }

    public function verDetalles($proformaId)
    {
        $this->proformaSeleccionada = Proforma::with(['client', 'detailProformas.product'])->find($proformaId);
        $this->modalDetallesAbierto = true;
    }

    public function verComprobantes($proformaId)
    {
        $this->proformaSeleccionada = Proforma::with(['client', 'comprobantes'])->find($proformaId);
        $this->comprobantes = $this->proformaSeleccionada->comprobantes;
        $this->accion = null;
        $this->modalComprobantesAbierto = true;
    }

    public function cerrarModal()
    {
        $this->reset([
            'proformaSeleccionada',
            'accion',
            'motivoRechazo',
            'modalDetallesAbierto'
        ]);
    }

    public function cerrarModalComprobantes()
    {
        $this->reset([
            'proformaSeleccionada',
            'comprobantes',
            'accion',
            'motivoRechazo',
            'modalComprobantesAbierto'
        ]);
    }

    public function prepararAccion($accion)
    {
        $this->accion = $accion;

        if ($accion === 'rechazar') {
            $this->motivoRechazo = '';
        }
    }


    public function confirmarAccion()
    {
        if ($this->accion === 'rechazar') {
            $this->validate([
                'motivoRechazo' => 'required|min:10',
            ]);

            $this->proformaSeleccionada->update([
                'status' => 'esperando_pago',
                'motivo_rechazo' => $this->motivoRechazo,
            ]);

            session()->flash('mensaje', 'Pago rechazado. El cliente debe subir nuevos comprobantes.');
        }

        if ($this->accion === 'aprobar') {
            $this->validate([
                'metodo_pago' => 'required|string|max:100',
            ]);

            // Obtener el cliente
            $cliente = Client::find($this->proformaSeleccionada->client_id);

            // --- Crear venta desde proforma ---
            $proforma = $this->proformaSeleccionada;
            $utilidadTotal = 0;

            $venta = Sale::create([
                'client_id' => $proforma->client_id,
                'user_id' => Auth::id(),
                'sale_date' => now(),
                'total' => $proforma->total,
                'utilidad_sale' => 0,
                'status_fac' => $proforma->factura === 'si' ? 'pendiente_facturacion' : 'no_aplicable',
                'estado_sale' => 'habil_sale',
            ]);

            foreach ($proforma->detailProformas as $detalle) {
                $product = Product::find($detalle->product_id);
                $purchasePrice = $product->purchase_price ?? 0;
                $utilidadDetalle = ($detalle->price - $purchasePrice) * $detalle->quantity;
                $utilidadTotal += $utilidadDetalle;

                SaleDetail::create([
                    'sale_id' => $venta->id,
                    'salable_type' => Product::class,
                    'salable_id' => $detalle->product_id,
                    'quantity' => $detalle->quantity,
                    'price' => $detalle->price,
                    'subtotal' => $detalle->subtotal,
                    'utilidad_saledetail' => $utilidadDetalle,
                    'estado_detail' => 'habil_detail',
                ]);

                if ($product) {
                    $product->stock = max(0, $product->stock - $detalle->quantity);
                    $product->save();
                }
            }

            $venta->update(['utilidad_sale' => $utilidadTotal]);

            // Actualizar proforma
            $proforma->update([
                'status' => 'pagado',
                'fecha_pago' => now(),
                'metodo_pago' => $this->metodo_pago,
                'correo_notificado' => !empty($cliente->email),
                'convertido_a_venta' => true,
            ]);

            // Enviar correo si hay email
            if (!empty($cliente->email)) {
                try {
                    Mail::to($cliente->email)
                        ->send(new PagoAprobadoCliente($this->proformaSeleccionada));

                    session()->flash('success', 'Pago aprobado y correo enviado correctamente.');
                } catch (\Exception $e) {
                    \Log::error('Error enviando correo de pago aprobado: ' . $e->getMessage());
                    session()->flash('warning', 'Pago aprobado pero no se pudo enviar el correo: ' . $e->getMessage());
                }
            } else {
                session()->flash('info', 'Pago aprobado pero el cliente no tiene correo registrado.');
            }
        }

        $this->reset([
            'proformaSeleccionada',
            'comprobantes',
            'accion',
            'motivoRechazo',
            'metodo_pago',
            'modalComprobantesAbierto'
        ]);

        $this->dispatch('cerrar-modal');
    }


    public function render()
    {
        $query = Proforma::with(['client', 'detailProformas.product'])
            ->orderByDesc('created_at');

        if ($this->filtroEstado !== 'todos') {
            $query->where('status', $this->filtroEstado);
        } else {
            $query->where('status', '!=', 'solocotizacion');
        }

        $ventas = $query->paginate(10);

        return view('livewire.ventas-online', [
            'ventas' => $ventas
        ])->layout('layouts.app');
    }
}
