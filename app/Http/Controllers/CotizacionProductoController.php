<?php

namespace App\Http\Controllers;

use App\Models\CotizacionProducto;
use Illuminate\Http\Request;

class CotizacionProductoController extends Controller
{
    public function agregarCotizacionProducto($datos)
    {
        try {
            $cotizacion_producto = new CotizacionProducto($datos);
            return $cotizacion_producto;
        } catch (\Illuminate\Database\QueryException $e) {
            return $e;
        }
    }
}
