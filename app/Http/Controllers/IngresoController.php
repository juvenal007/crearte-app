<?php

namespace App\Http\Controllers;

use App\Models\Bodega;
use App\Models\BodegaProducto;
use App\Models\Cotizacion;
use App\Models\CotizacionProducto;
use App\Models\Estado;
use App\Models\Ingreso;
use App\Models\OrdenCompra;
use App\Models\Producto;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IngresoController extends Controller
{
    public function add(Request $request)
    {
        try {    
            DB::beginTransaction();
            $cotizacion = Cotizacion::find($request->data['ordenCompra']['cotizacion']['id']);
            $ordenCompra = OrdenCompra::find($request->data['ordenCompra']['id']);
            $solicitud = Solicitud::find($request->data['ordenCompra']['cotizacion']['solicitud']['id']);
            
            $bodega = Bodega::find(1);

            if(!isset($bodega))
            {
                $datosBodega = [
                    'bodega_nombre' => 'Bodega General',
                    'bodega_descripcion' => 'Descripción Bodega'
                ];
                $bodega = new Bodega($datosBodega);

                $bodega->save();
            }

            

            $datosIngreso = [
                'ingreso_oc_id' => $ordenCompra->id,
                'ingreso_bodega_id' => $bodega->id
            ];

            $ingreso = new Ingreso($datosIngreso);
            $ingreso->save();


            $productosCotizacion = CotizacionProducto::where('cp_cotizacion_id', $cotizacion->id)->get();
            //return response()->json(['response' => ['status' => true, 'data' => $productosCotizacion, 'message' => 'Productos Agregados a Bodega']], 200);
            foreach ($productosCotizacion as $atributo => $producto) {

                $productoBase = Producto::find($producto['cp_producto_id']);     
                //return response()->json(['response' => ['status' => true, 'data' => $productosCotizacion, 'message' => 'Productos Agregados a Bodega']], 200);
                $datosBodegaProducto = [
                    'bp_cantidad' => intval($producto['cp_cantidad']),
                    'bp_precio' => floatval($producto['cp_precio']),
                    'bp_total' => intval($producto['cp_total']),
                    'bp_existencia' => intval($producto['cp_cantidad']),
                    'bp_producto_id' => $productoBase->id,
                    'bp_ingreso_id' => $ingreso->id,
                ];

                $bodegaProducto = new BodegaProducto($datosBodegaProducto);
                $bodegaProducto->save();
            }

            $estadoOrden = Estado::where('estado', 'ORDEN_TERMINADA')->first(); 
            $ordenCompra->oc_estado_id = $estadoOrden->id;
            $ordenCompra->save();

            $estadoSolicitud = Estado::where('estado', 'SOLICITUD_TERMINADA')->first();
            $solicitud->solicitud_estado_id = $estadoSolicitud->id;
            $solicitud->save();

            $estadoCotizacion = Estado::where('estado', 'COTIZACION_TERMINADA')->first();
            $cotizacion->cotizacion_estado_id = $estadoCotizacion->id;
            $cotizacion->save();


            DB::commit();

            return response()->json(['response' => ['status' => true, 'data' => $ingreso, 'message' => 'Productos Agregados a Bodega']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 500);
        }
    }
}
