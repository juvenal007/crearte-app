<?php

namespace App\Http\Controllers;

use App\Models\TipoSolicitud;
use Illuminate\Http\Request;

class TipoSolicitudController extends Controller
{
    public function list()
    {
        try {
            $tipoSolicitud = TipoSolicitud::all();
            if ($tipoSolicitud->count() <= 0) {
                return response()->json(['response' => ['type_error' => 'not_allowed', 'status' => false, 'data' => [], 'message' => "No se encontraron solicitudes"]], 404);
            }
            return response()->json(['response' => ['status' => true, 'data' => $tipoSolicitud, 'message' => 'Query success']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 500);
        }
    }
}
