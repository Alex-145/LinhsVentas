<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PrediccionService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = 'http://127.0.0.1:8010'; // URL local de la API FastAPI
    }

    /**
     * Obtiene la predicción flexible para un producto dado.
     *
     * @param int $productoId
     * @param int $anio
     * @param int $mesInicio
     * @param int $meses
     * @return array|null
     */
    public function obtenerPrediccionFlexible(int $productoId, int $anio, int $mesInicio, int $meses = 12): ?array
    {
        $response = Http::get("{$this->baseUrl}/prediccion-flexible", [
            'producto_id' => $productoId,
            'anio' => $anio,
            'mes_inicio' => $mesInicio,
            'meses' => $meses,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}
