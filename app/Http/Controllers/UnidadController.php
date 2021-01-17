<?php

namespace App\Http\Controllers;

use App\Models\Unidad;
use Illuminate\Http\Request;

class UnidadController extends Controller
{
    public function list()
    {
        try {

            $unidad = Unidad::all();
            if ($unidad->count() <= 0) {
                return response()->json(['response' => ['type_error' => 'not_allowed', 'status' => false, 'data' => [], 'message' => "No se encontraron unidades"]], 404);
            }
            return response()->json(['response' => ['status' => true, 'data' => $unidad, 'message' => 'Query success']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 500);
        }
    }
}
