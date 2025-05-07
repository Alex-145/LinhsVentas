<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SunatService
{
    public static function buscarPorRuc($ruc)
    {
        $token = 'apis-token-14820.KfTVQkF0rhs1B3NoZiOmeTEP4R1o6UCa';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Referer' => 'http://apis.net.pe/api-ruc'
        ])->get("https://api.apis.net.pe/v2/sunat/ruc", [
            'numero' => $ruc
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

}
