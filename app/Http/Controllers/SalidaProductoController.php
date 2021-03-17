<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\DetalleSolicitud;
use App\Models\Estado;
use App\Models\SalidaProducto;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SalidaProductoController extends Controller
{
    public function list($idCliente)
    {
        try {

            $estadoCliente = Estado::where('estado', 'CLIENTE_ACTIVO')->first();
            $cliente = Cliente::with('proyecto', 'proyecto.centro_costo')->where('cliente_estado_id', $estadoCliente->id)->find($idCliente);
            $detalleSolicitud = DetalleSolicitud::where('ds_cliente_id', $cliente->id)->where('ds_proyecto_id', $cliente->proyecto->id)->where('ds_centro_costo_id', $cliente->proyecto->centro_costo->id)->first();

            $salidaProductos = SalidaProducto::with('salida', 'producto', 'producto.unidad')->where('sp_detalle_solicitud_id' , $detalleSolicitud->id)->get();         

            $productos = [];

            $total = 0;

            foreach ($salidaProductos as $key => $producto) {
                $fechaIngreso = Carbon::parse($producto->created_at)->format('d-m-Y H:i:s');
                $fechaIngreso = Carbon::create($fechaIngreso);
                $producto->fecha_ingreso = $fechaIngreso->format('d-m-Y H:i:s');

                $total += $producto->sp_total;
                $producto->sp_total = "$ ".number_format($producto->sp_total, NULL, ",", ".");
                $producto->sp_precio = "$ ".number_format($producto->sp_precio, NULL, ",", ".");
                array_push($productos, $producto);
            }   
            
            $datoTotal = [
                'totalProductos' => "$ ".number_format($total, NULL, ",", ".")
            ];

        

            return response()->json(['response' => ['status' => true, 'data' => ['productos' => $productos, 'total' => $datoTotal], 'message' => 'Salida creada.']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            // SI FALLA VOLVEMOS AL ESTADO INICIAL
            //DB::rollback();
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 500);
        }
    }
}
