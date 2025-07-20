<?php

namespace App\Livewire\Pageweb;

use App\Models\Proforma;
use App\Models\Comprobante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class VerificarPedido extends Component
{
    use WithFileUploads;

    public string $codigo = '';
    public ?Proforma $proforma = null;
    public $archivos_comprobantes = []; // Cambiado a propiedad pública sin tipo definido
    public array $archivos_subidos = []; // Nueva propiedad para acumular archivos
    public string $mensaje_error = '';

    public function mount(Request $request): void
    {
        Session::forget('cart');
        $this->reset(['archivos_comprobantes', 'mensaje_error', 'proforma', 'archivos_subidos']);

        if ($request->has('codigo')) {
            $this->codigo = $request->codigo;
            $this->buscarProforma();
        }
    }

    public function updatedArchivosComprobantes(): void
    {
        $this->validate([
            'archivos_comprobantes.*' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Agregar los nuevos archivos a la lista de archivos subidos
        foreach ($this->archivos_comprobantes as $archivo) {
            $this->archivos_subidos[] = $archivo;
        }

        // Limpiar el input de archivos para permitir nuevas selecciones
        $this->archivos_comprobantes = [];
    }

    public function buscarProforma(): void
    {
        $this->reset(['proforma', 'mensaje_error', 'archivos_subidos']);

        $this->proforma = Proforma::with('client', 'detailProformas')->where('codigo', $this->codigo)->first();

        if (!$this->proforma) {
            $this->mensaje_error = 'El código ingresado no corresponde a ningún pedido.';
        } elseif (in_array($this->proforma->status, ['cerrado', 'cancelado', 'cerrado_por_vencimiento'])) {
            $this->mensaje_error = 'Este pedido ya fue cerrado o cancelado. Si cree que es un error, contáctenos.';
        }
    }

    public function subirComprobante(): void
    {
        if (!$this->proforma) {
            $this->mensaje_error = 'Debe buscar primero un pedido válido antes de subir un comprobante.';
            return;
        }

        if (empty($this->archivos_subidos)) {
            $this->mensaje_error = 'Debe subir al menos un archivo.';
            return;
        }

        foreach ($this->archivos_subidos as $archivo) {
            $ruta = $archivo->store('comprobantes', 'public');

            Comprobante::create([
                'proforma_id' => $this->proforma->id,
                'archivo_url' => $ruta,
            ]);
        }

        $this->proforma->update([
            'status' => 'esperando_verificacion',
        ]);

        $this->reset(['archivos_comprobantes', 'archivos_subidos']);

        session()->flash('success', 'Comprobante(s) subido(s) correctamente. Pronto verificaremos tu pago.');
    }

    public function eliminarArchivo($index): void
    {
        if (isset($this->archivos_subidos[$index])) {
            unset($this->archivos_subidos[$index]);
            $this->archivos_subidos = array_values($this->archivos_subidos); // Reindexar el array
        }
    }

    public function render()
    {
        return view('livewire.pageweb.verificar-pedido')->layout('layouts.index');
    }
}
