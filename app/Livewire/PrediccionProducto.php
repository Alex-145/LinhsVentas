<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use App\Models\Product;

class PrediccionProducto extends Component
{
    public $productoId;
    public $anio;
    public $mesInicio;
    public $meses = 6;

    public $predicciones = [];
    public $errorApi = null;
    public $cargando = false;

    // Propiedades para el buscador
    public $search = '';
    public $resultsProduct = [];
    public $showlist = false;
    public $selectedProductName = '';
    public $productoSeleccionado = false;

    protected $rules = [
        'productoId' => 'required|integer|min:1',
        'anio' => 'required|integer|min:2000|max:2100',
        'mesInicio' => 'required|integer|min:1|max:12',
        'meses' => 'required|integer|min:1|max:24'
    ];

    protected $messages = [
        'productoId.required' => 'Debes seleccionar un producto de la lista',
        'anio.required' => 'El año es requerido',
        'mesInicio.required' => 'El mes inicial es requerido',
        'meses.required' => 'La cantidad de meses es requerida',
        'min' => 'El valor mínimo es :min',
        'max' => 'El valor máximo es :max'
    ];

    public function searchProduct()
    {
        $this->productoSeleccionado = false;
        $this->resultsProduct = [];

        if (!empty($this->search)) {
            $this->resultsProduct = Product::where('name', 'like', '%' . $this->search . '%')
                ->orderBy('name', 'asc')
                ->limit(10)
                ->get();

            $this->showlist = $this->resultsProduct->isNotEmpty();
        } else {
            $this->showlist = false;
        }
    }

    public function selectProduct($productId, $productName)
    {
        $this->productoId = $productId;
        $this->selectedProductName = $productName;
        $this->search = $productName;
        $this->showlist = false;
        $this->productoSeleccionado = true;
        $this->resetErrorBag();
    }

    public function updatedSearch()
    {
        if ($this->productoSeleccionado) {
            $this->productoSeleccionado = false;
            $this->productoId = null;
        }
    }

    public function obtenerPrediccion()
    {
        // Validación adicional antes de la validación formal
        if (!$this->productoSeleccionado) {
            $this->addError('productoId', 'Debes seleccionar un producto de la lista');
            return;
        }

        $this->validate();

        $this->reset(['predicciones', 'errorApi']);
        $this->cargando = true;

        try {
            $response = Http::timeout(30)->get('http://127.0.0.1:8010/prediccion-flexible', [
                'producto_id' => $this->productoId,
                'anio' => $this->anio,
                'mes_inicio' => $this->mesInicio,
                'meses' => $this->meses
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $this->predicciones = $this->formatearPredicciones($data);
            } else {
                $this->errorApi = 'Error en la API: ' . $response->status();
            }
        } catch (\Exception $e) {
            $this->errorApi = 'Error al conectar con la API: ' . $e->getMessage();
        } finally {
            $this->cargando = false;
        }
    }
    protected function formatearPredicciones(array $data): array
    {
        $formateado = [];
        $prevValue = null;

        foreach ($data as $item) {
            if (isset($item['ds']) && isset($item['yhat'])) {
                $fecha = \DateTime::createFromFormat('Y-m-d', $item['ds']);
                $currentValue = (float)$item['yhat'];
                $tendencia = null;

                if ($prevValue !== null && $prevValue != 0) {
                    $tendencia = (($currentValue - $prevValue) / $prevValue) * 100;
                }

                $formateado[] = [
                    'mes' => $fecha ? $fecha->format('F Y') : $item['ds'], // Formato más legible
                    'demanda' => number_format($currentValue, 2),
                    'tendencia' => $tendencia !== null ? round($tendencia, 2) : null,
                    'valor_numerico' => $currentValue // Para el gráfico
                ];

                $prevValue = $currentValue;
            }
        }

        return $formateado;
    }

    public function clearProduct()
    {
        $this->reset([
            'productoId',
            'selectedProductName',
            'search',
            'resultsProduct',
            'showlist'
        ]);
    }

    public function resetForm()
    {
        $this->reset([
            'productoId',
            'selectedProductName',
            'search',
            'resultsProduct',
            'showlist',
            'anio',
            'mesInicio',
            'meses',
            'predicciones',
            'errorApi'
        ]);
    }

    public function generateChart()
    {
        // Asegúrate de que hay predicciones para mostrar
        if (empty($this->predicciones)) {
            return;
        }

        // Dispara el evento con los datos formateados correctamente
        $this->dispatch(
            'prediccionesActualizadas',
            predicciones: $this->predicciones
        );
    }

    public function render()
    {
        return view('livewire.prediccion-producto')->layout('layouts.app');
    }
}
