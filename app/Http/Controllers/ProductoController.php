<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function list()
    {
        $productos = Producto::all();
        return response()->json(['response' => ['status' => true, 'data' => $productos, 'message' => 'Query success']], 200);
    }
    public function buscarProducto($id)
    {
        try {
            $producto = Producto::find($id)->first();
            return $producto;
        } catch (\Illuminate\Database\QueryException $e) {
            return $e;
        }
    }
}
