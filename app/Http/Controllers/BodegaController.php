<?php

namespace App\Http\Controllers;

use App\Exports\BodegasExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Bodega;
use Illuminate\Http\Request;

class BodegaController extends Controller
{
    public function informe()
    {
        try {

            $bodega = Bodega::find(1);

            $fecha = date("d-m-Y-H-i-s");
            $informeBodega = 'INFORME-BODEGA-' . $bodega->bodega_nombre . "-" . $fecha . ".xlsx";

            return Excel::download(new BodegasExport($bodega->id), $informeBodega);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 200);
        }
    }
}
