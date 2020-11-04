<?php

namespace Rchaname\Consultadni;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ConsultaAPI
{

    public function getDniApiDevPeru($dni)
    {
        $token = getenv('API_DNI_TOKEN');
        $url = "https://apiperu.dev/api/dni/" . $dni;
        $respuesta = Http::withToken($token)->get($url);
        if ($respuesta->successful()) {
            if ($respuesta['success'] === true) {
                $data = $respuesta['data'];
                return [
                    'apellido_paterno' => $data['apellido_paterno'],
                    'apellido_materno' => $data['apellido_materno'],
                    'nombres' => $data['nombres']
                ];
            } else {
                Log::error($respuesta['message']);
                return [];
            }
        } else {
            Log::error("Error al conectar con proveedor");
            return [];
        }
    }

    public function getDniOptimizePeru($dni)
    {
        $url = "https://dni.optimizeperu.com/api/persons/" . $dni;
        $respuesta = Http::get($url);
        if ($respuesta->successful()) {

            return [
                'apellido_paterno' => $respuesta['first_name'],
                'apellido_materno' => $respuesta['last_name'],
                'nombres' => $respuesta['name']
            ];
        } else {
            Log::error("Error al conectar con proveedor");
            return [];
        }
    }
}
