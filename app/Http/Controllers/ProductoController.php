<?php

namespace App\Http\Controllers;

use App\Exports\ProductosExport;
use App\Models\Producto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProductoController extends Controller
{
    public function list()
    {
        $productos = Producto::all();
        return response()->json(['response' => ['status' => true, 'data' => $productos, 'message' => 'Query success']], 200);
    }

    public function list_all()
    {
        $productos = Producto::withTrashed()->with('unidad', 'proveedor')->orderBy('producto_material', 'ASC')->get();
        if ($productos->count() <= 0) {
            return response()->json(['response' => ['type_error' => 'not_allowed', 'status' => false, 'data' => [], 'message' => "No se encontraron Productos"]], 404);
        }

        $datosProductos = [];

            foreach ($productos as $key => $producto) {
                $fechaIngreso = Carbon::parse($producto->created_at)->format('d-m-Y H:i:s');
                $fechaIngreso = Carbon::create($fechaIngreso);
                $producto->fecha_ingreso = $fechaIngreso->format('d-m-Y H:i:s');

                $productoDato = [
                    'producto_precio' => "$ ".number_format(intval($producto->producto_precio), NULL, ",", "."),
                    'producto_material' => $producto->producto_material,
                    'producto_descripcion' => $producto->producto_descripcion,
                    'producto_unidad' => $producto['unidad']->unidad_nombre,
                    'producto_proveedor' => $producto['proveedor']->proveedor_nombre,
                    'producto_telefono' => $producto['proveedor']->proveedor_telefono,
                ];

                array_push($datosProductos, $productoDato);
            }

        return response()->json(['response' => ['status' => true, 'data' => $datosProductos, 'message' => 'Query success']], 200);
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

    public function informe()
    {
        try {

            $fecha = date("d-m-Y-H-i-s");
            $informeProductos = 'INFORME-PRODUCTOS-'. $fecha . ".xlsx";

            return Excel::download(new ProductosExport, $informeProductos);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 200);
        }
    }
}
