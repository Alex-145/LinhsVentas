<?php

namespace App\Livewire\Pageweb;

use App\Mail\CodigoProformaMail;
use App\Models\Client;
use App\Models\Proforma;
use App\Models\ProformaDetail;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class FinalSale extends Component
{
    public $cart = [];
    public $total = 0;
    public $subtotal = 0;
    public $igv = 0;

    public $dni, $name, $email, $phone_number, $ruc, $business_name;
    public $message = '';
    public $isNewClient = false;
    public $necesitaFactura;


    public $mostrarModalCodigo = false;
    public $codigoGenerado = '';
    public $codigoIngresado = '';
    public $procesando = false;
    public $mostrarModalVerificacionPedido = false;
    public bool $descargaExitosa = false;
    public bool $cotizacionGenerada = false;


    public function cerrarModalDescarga()
    {
        $this->descargaExitosa = false;
    }

    public function mount()
    {
        $this->cart = Session::get('cart', []);
        $this->total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $this->cart));
        $this->subtotal = $this->total / 1.18;
        $this->igv = $this->total - $this->subtotal;
    }

    public function searchClient()
    {
        $client = Client::where('dni', $this->dni)->first();

        if ($client) {
            $this->name = $client->name;
            $this->email = $client->email;
            $this->phone_number = $client->phone_number;
            $this->ruc = $client->ruc;
            $this->business_name = $client->business_name;
            $this->message = '';
            $this->isNewClient = false;
        } else {
            $this->reset(['name', 'email', 'phone_number', 'ruc', 'business_name']);
            $this->message = 'Cliente no encontrado. Por favor, complete sus datos.';
            $this->isNewClient = true;
        }
    }

    public function render()
    {
        return view('livewire.pageweb.final-sale')->layout('layouts.index');
    }

    public function reenviarCodigo()
    {
        if (empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            session()->flash('error', 'No se puede reenviar el código porque el correo es inválido o no está definido.');
            return;
        }

        // Si no hay un código previamente generado, genera uno nuevo y guarda
        if (empty($this->codigoGenerado)) {
            $this->codigoGenerado = $this->generarCodigoProforma();
        }

        try {
            $this->enviarCodigoPorCorreo($this->email, $this->codigoGenerado);
            session()->flash('success', 'El código ha sido reenviado correctamente a tu correo.');
        } catch (\Exception $e) {
            session()->flash('error', 'Ocurrió un error al reenviar el código. Inténtalo más tarde.');
        }
    }


    public function generarProforma()
    {
        $this->validate([
            'name' => 'required|string',
        ], [
            'name.required' => 'El nombre es obligatorio.',
        ]);

        $fecha = Carbon::now();
        $fechaVencimiento = $fecha->copy()->addDays(3);
        $codigo = $this->generarCodigoProforma();

        $client = Client::firstOrCreate(['dni' => $this->dni], [
            'name' => $this->name,
            'email' => $this->email ?? null,
            'phone_number' => $this->phone_number ?? null,
            'ruc' => $this->necesitaFactura ? ($this->ruc ?? null) : null,
            'business_name' => $this->necesitaFactura ? ($this->business_name ?? null) : null,
        ]);

        $proforma = Proforma::create([
            'client_id' => $client->id,
            'codigo' => $codigo,
            'factura' => $this->necesitaFactura ? 'si' : 'no',
            'status' => 'solocotizacion',
            'fecha_vencimiento' => $fechaVencimiento,
            'total' => $this->total,
            'metodo_pago' => null,
            'correo_notificado' => false,
            'fecha_pago' => null,
            'fecha_confirmacion' => null,
            'comprobante_url' => null,
            'convertido_a_venta' => false,
        ]);

        foreach ($this->cart as $item) {
            ProformaDetail::create([
                'proforma_id' => $proforma->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);
        }

        $clienteData = [
            'dni' => $this->dni,
            'name' => $this->name,
            'email' => $this->email ?? '',
            'phone_number' => $this->phone_number ?? '',
            'ruc' => $this->ruc ?? '',
            'business_name' => $this->business_name ?? '',
        ];

        $data = [
            'cliente' => $clienteData,
            'cart' => $this->cart,
            'subtotal' => $this->subtotal,
            'igv' => $this->igv,
            'total' => $this->total,
            'fecha' => $fecha,
            'fecha_vencimiento' => $fechaVencimiento,
        ];

        // ✅ Nuevo: marcar como descargado para desactivar botón desde Livewire
        $this->descargaExitosa = true;
        $this->cotizacionGenerada = true;

        // ✅ No limpiar ni resetear campos

        // Generar y retornar el PDF
        $pdf = Pdf::loadView('pdf.proforma', $data)->setPaper('A4');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'proforma_' . now()->format('Ymd_His') . '.pdf');
    }





    private function generarCodigoProforma($length = 8)
    {
        $prefix = 'PROF-';
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $random = '';

        do {
            $random = '';
            for ($i = 0; $i < $length; $i++) {
                $random .= $characters[rand(0, strlen($characters) - 1)];
            }
            $codigo = $prefix . $random;
        } while (Proforma::where('codigo', $codigo)->exists());

        return $codigo;
    }

    private function enviarCodigoPorCorreo($correo, $codigo)
    {
        if (empty($correo) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            // Puedes registrar el error si quieres monitorearlo
            \Log::warning("No se envió el correo porque el correo es inválido: {$correo}");
            return;
        }

        try {
            Mail::to($correo)->send(new CodigoProformaMail($codigo));
        } catch (\Exception $e) {
            \Log::error("Error al enviar código a {$correo}: " . $e->getMessage());
            // También podrías usar session()->flash() aquí si deseas mostrarlo al usuario
        }
    }


    public function confirmarCompra()
    {
        // Validar
        $this->validate([
            'dni' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|string',
            'necesitaFactura' => 'nullable|boolean',
            'ruc' => 'required_if:necesitaFactura,true|string|nullable',
            'business_name' => 'required_if:necesitaFactura,true|string|nullable',
        ], [
            'dni.required' => 'El DNI es obligatorio.',
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email no es válido.',
            'phone_number.required' => 'El teléfono es obligatorio.',
            'ruc.required_if' => 'El RUC es obligatorio si necesita factura.',
            'business_name.required_if' => 'La razón social es obligatoria si necesita factura.',
        ]);

        $fecha = now();
        $fechaVencimiento = $fecha->copy()->addDays(3);
        $codigo = $this->generarCodigoProforma();

        // Guardar cliente
        $client = Client::firstOrCreate(['dni' => $this->dni], [
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'ruc' => $this->ruc,
            'business_name' => $this->business_name,
        ]);

        // Crear proforma
        $proforma = Proforma::create([
            'client_id' => $client->id,
            'codigo' => $codigo,
            'factura' => $this->necesitaFactura ? 'si' : 'no',
            'status' => 'esperando_pago',
            'fecha_vencimiento' => $fechaVencimiento,
            'total' => $this->total,
        ]);

        // Guardar detalles
        foreach ($this->cart as $item) {
            ProformaDetail::create([
                'proforma_id' => $proforma->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['quantity'] * $item['price'],
            ]);
        }

        // Enviar código al correo
        $this->enviarCodigoPorCorreo($this->email, $codigo);

        // Guardar código para verificar
        $this->codigoGenerado = $codigo;
        $this->mostrarModalCodigo = true;
        $this->procesando = false;
    }



    public function verificarCodigo()
    {
        if ($this->codigoIngresado === $this->codigoGenerado) {
            session()->flash('success', 'Código verificado. Puede continuar con la subida de su comprobante.');

            return redirect()->route('verificar.pedido', ['codigo' => $this->codigoGenerado]);
        } else {
            session()->flash('error', 'El código ingresado no es válido.');
        }
    }
}
