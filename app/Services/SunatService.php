<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SunatService
{
    protected $token;
    protected $baseUrl = 'https://api.apis.net.pe/v2/sunat';

    public function __construct()
    {
        $this->token = config('services.apis_net_pe.token', 'apis-token-16292.NHF50v1v0VgJUZ2Gtlvyz0wukdkeR0Pu');
    }

    public static function buscarPorRuc($ruc)
    {
        $instance = new self();
        return $instance->consultarRuc($ruc);
    }

    public static function buscarPorDni($dni)
    {
        $instance = new self();
        return $instance->consultarDni($dni);
    }

    protected function consultarRuc($ruc)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
                'Referer' => config('services.apis_net_pe.referer', 'http://apis.net.pe/api-ruc')
            ])->get("{$this->baseUrl}/ruc", [
                'numero' => $ruc
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Error al consultar RUC', [
                'ruc' => $ruc,
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Excepción al consultar RUC: ' . $e->getMessage());
            return null;
        }
    }

    protected function consultarDni($dni)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
                'Referer' => config('services.apis_net_pe.referer', 'http://apis.net.pe/api-dni')
            ])->get("{$this->baseUrl}/dni", [
                'numero' => $dni
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Error al consultar DNI', [
                'dni' => $dni,
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Excepción al consultar DNI: ' . $e->getMessage());
            return null;
        }
    }
}
