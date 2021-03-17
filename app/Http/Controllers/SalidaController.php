<?php

namespace App\Http\Controllers;

use App\Models\BodegaProducto;
use App\Models\CentroCosto;
use App\Models\Cliente;
use App\Models\DetalleSolicitud;
use App\Models\Proyecto;
use App\Models\Salida;
use App\Models\SalidaProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalidaController extends Controller
{
    public function add(Request $request){

        try {

            $cliente = Cliente::find($request->data['cliente']['id']);
            $proyecto = Proyecto::find($request->data['proyecto']['id']);
            $centro_costo = CentroCosto::find($request->data['centro_costo']['id']);

            $detalle_solicitud = DetalleSolicitud::where('ds_centro_costo_id', $centro_costo->id)->where('ds_proyecto_id', $proyecto->id)->where('ds_cliente_id', $cliente->id)->first();
           
            $datos = [
                'salida_nombre_salida' => $request->data['solicitud_nombre'],
                'salida_nombre_solicitante' => $request->data['solicitud_nombre_solicitante'],
                'salida_descripcion' => $request->data['solicitud_descripcion']
            ];

            $salida = new Salida($datos);
            $salida->save();           

            foreach ($request->data['carro'] as $key => $producto) {
               $bodegaProducto = BodegaProducto::find($producto['id']);
               $bodegaProducto->bp_existencia = intval($bodegaProducto->bp_existencia)-intval($producto['cantidad']);

               if($bodegaProducto->bp_existencia == 0){
                   $bodegaProducto->delete();
               }

               $bodegaProducto->save();
               $datosProductoSalida = [
                   'sp_cantidad' => intval($producto['cantidad']),
                   'sp_precio' => floatval($producto['bp_precio']),
                   'sp_total' => intval(intval($producto['cantidad'])*floatval($producto['bp_precio'])),
                   'sp_producto_id' => $producto['producto']['id'],
                   'sp_salida_id' => $salida->id,
                   'sp_detalle_solicitud_id' => $detalle_solicitud->id
               ];
               $salidaProducto = new SalidaProducto($datosProductoSalida);
               $salidaProducto->save();
            }       

           



            // INDICAMOS A MYSQL EL TIPO DE TRANSACCIÓN YA QUE SERÁN SIMULTANEAS
            DB::beginTransaction();
       

            // GUARDAMOS EN LA BASE DE DATOS
            DB::commit();

            return response()->json(['response' => ['status' => true, 'data' => $request->data['carro'], 'message' => 'Salida creada.']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            // SI FALLA VOLVEMOS AL ESTADO INICIAL
            DB::rollback();
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 500);
        }

    }
}
