<?php

namespace App\Http\Controllers;

use App\Models\BodegaProducto;
use App\Models\CentroCosto;
use App\Models\Cliente;
use App\Models\Cotizacion;
use App\Models\DetalleSolicitud;
use App\Models\Estado;
use App\Models\Ingreso;
use App\Models\OrdenCompra;
use App\Models\Proyecto;
use App\Models\Solicitud;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BodegaProductoController extends Controller
{
    public function list_all(){
        try {
            $productosBodega = BodegaProducto::with('producto', 'producto.unidad', 'ingreso.orden_compra.cotizacion.solicitud.tipo_solicitud')->where('bp_existencia', ">", 0 )->get();
            if ($productosBodega->count() <= 0) {
                return response()->json(['response' => ['type_error' => 'not_allowed', 'status' => false, 'data' => [], 'message' => "No se encontro producto en bodega"]], 404);
            }
            $datosProductos = [];
            
            foreach ($productosBodega as $key => $producto) {
                $fechaIngreso = Carbon::parse($producto->created_at)->format('d-m-Y H:i:s');
                $fechaIngreso = Carbon::create($fechaIngreso);
                $producto->fecha_ingreso = $fechaIngreso->format('d-m-Y H:i:s'); 
                
                $productoDato = [                    
                    'bp_existencia' => $producto->bp_cantidad,
                    'bp_precio' => "$ ".number_format(intval($producto->bp_precio), NULL, ",", "."),
                    'bp_total' => "$ ".number_format($producto->bp_total, NULL, ",", "."),
                    'bp_fecha' => $producto->fecha_ingreso,
                    'bp_producto_material' => $producto['producto']->producto_material,
                    'bp_producto_descripcion' => $producto['producto']->producto_descripcion,
                    'bp_producto_unidad' => $producto['producto']['unidad']->unidad_nombre,
                    'bp_tipo_solicitud' => $producto['ingreso']['orden_compra']['cotizacion']['solicitud']['tipo_solicitud']->ts_nombre
                ];

                array_push($datosProductos, $productoDato);
            }   
            return response()->json(['response' => ['status' => true, 'data' => $datosProductos, 'message' => 'Query success']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 500);
        }
       
    }
    public function getProductosBodega($idCliente)
    {
        try {
            $estadoCliente = Estado::where('estado', 'CLIENTE_ACTIVO')->first();
            $estadoSolicitud = Estado::where('estado', 'SOLICITUD_TERMINADA')->first();
            $estadoCotizacion = Estado::where('estado', 'COTIZACION_TERMINADA')->first();
            $estadoOrdenCompra = Estado::where('estado', 'ORDEN_TERMINADA')->first();
            $cliente = Cliente::with('proyecto', 'proyecto.centro_costo')->where('cliente_estado_id', $estadoCliente->id)
                ->where('id', $idCliente)
                ->first();

            if ($cliente->count() <= 0) {
                return response()->json(['response' => ['type_error' => 'not_allowed', 'status' => false, 'data' => [], 'message' => "No se encontro cliente"]], 404);
            }

            $proyecto = Proyecto::find($cliente->proyecto->id);

            $centroCosto = CentroCosto::find($cliente->proyecto->centro_costo->id);

            $solicitudGeneral = Solicitud::where('solicitud_detalle_solicitud_id', NULL)->where('solicitud_estado_id', $estadoSolicitud->id)->get();

            $detalleCentroCosto = DetalleSolicitud::where('ds_centro_costo_id', $cliente->proyecto->centro_costo->id)->where('ds_proyecto_id', NULL)->where('ds_cliente_id', NULL)->first();

            $solicitudCentroCosto = Solicitud::where('solicitud_detalle_solicitud_id', $detalleCentroCosto->id)->where('solicitud_estado_id', $estadoSolicitud->id)->get();

            $detalleProyecto = DetalleSolicitud::where('ds_centro_costo_id', $cliente->proyecto->centro_costo->id)->where('ds_proyecto_id', $cliente->proyecto->id)->where('ds_cliente_id', NULL)->first();

            $solicitudProyecto = Solicitud::where('solicitud_detalle_solicitud_id', $detalleProyecto->id)->where('solicitud_estado_id', $estadoSolicitud->id)->get();

            $detalleCliente = DetalleSolicitud::where('ds_centro_costo_id', $cliente->proyecto->centro_costo->id)->where('ds_proyecto_id', $cliente->proyecto->id)->where('ds_cliente_id', $cliente->id)->first();

            $solicitudCliente = Solicitud::where('solicitud_detalle_solicitud_id', $detalleCliente->id)->where('solicitud_estado_id', $estadoSolicitud->id)->get();


            $totalCotizaciones = [];

            $productosSalida = [];

            foreach ($solicitudGeneral as $key => $solicitud) {
                $cotizacion = Cotizacion::where('cotizacion_solicitud_id', $solicitud->id)->where('cotizacion_estado_id', $estadoCotizacion->id)->first();
                if (isset($cotizacion)) {
                    $ordenCompra = OrdenCompra::where('oc_cotizacion_id', $cotizacion->id)->where('oc_estado_id', $estadoOrdenCompra->id)->first();
                    $ingreso = Ingreso::where('ingreso_oc_id', $ordenCompra->id)->first();
                    $tipoSolicitud = BodegaProducto::with('ingreso.orden_compra.cotizacion.solicitud.tipo_solicitud','producto','producto.unidad')->where('bp_ingreso_id', $ingreso->id)->get();
                                    
                    $productos = BodegaProducto::with('producto','producto.unidad')->where('bp_ingreso_id', $ingreso->id)->get();
                    foreach ($productos as $key => $productosBodega) {   
                        $productosBodega->tipo_solicitud = $tipoSolicitud[$key]['ingreso']['orden_compra']['cotizacion']['solicitud']->tipo_solicitud;;                                         
                        array_push($productosSalida, $productosBodega);
                    }
                }               
            }
           
            foreach ($solicitudCentroCosto as $key => $solicitud) {
                $cotizacion = Cotizacion::where('cotizacion_solicitud_id', $solicitud->id)->where('cotizacion_estado_id', $estadoCotizacion->id)->first();
                if (isset($cotizacion)) {
                    $ordenCompra = OrdenCompra::where('oc_cotizacion_id', $cotizacion->id)->where('oc_estado_id', $estadoOrdenCompra->id)->first();
                    $ingreso = Ingreso::where('ingreso_oc_id', $ordenCompra->id)->first();
                    $tipoSolicitud = BodegaProducto::with('ingreso.orden_compra.cotizacion.solicitud.tipo_solicitud','producto','producto.unidad')->where('bp_ingreso_id', $ingreso->id)->get();
                                  
                    $productos = BodegaProducto::with('producto','producto.unidad')->where('bp_ingreso_id', $ingreso->id)->get();
                    foreach ($productos as $key => $productosBodega) {   
                        $productosBodega->tipo_solicitud = $tipoSolicitud[$key]['ingreso']['orden_compra']['cotizacion']['solicitud']->tipo_solicitud;;                                         
                        array_push($productosSalida, $productosBodega);
                    }
                }        
            }
            foreach ($solicitudProyecto as $key => $solicitud) {
                $cotizacion = Cotizacion::where('cotizacion_solicitud_id', $solicitud->id)->where('cotizacion_estado_id', $estadoCotizacion->id)->first();
                if (isset($cotizacion)) {
                    $ordenCompra = OrdenCompra::where('oc_cotizacion_id', $cotizacion->id)->where('oc_estado_id', $estadoOrdenCompra->id)->first();
                    $ingreso = Ingreso::where('ingreso_oc_id', $ordenCompra->id)->first();
                    $tipoSolicitud = BodegaProducto::with('ingreso.orden_compra.cotizacion.solicitud.tipo_solicitud','producto','producto.unidad')->where('bp_ingreso_id', $ingreso->id)->get();
                               
                    $productos = BodegaProducto::with('producto','producto.unidad')->where('bp_ingreso_id', $ingreso->id)->get();
                    foreach ($productos as $key => $productosBodega) {   
                        $productosBodega->tipo_solicitud = $tipoSolicitud[$key]['ingreso']['orden_compra']['cotizacion']['solicitud']->tipo_solicitud;;                                         
                        array_push($productosSalida, $productosBodega);
                    }
                }        
            }
            foreach ($solicitudCliente as $key => $solicitud) {
                $cotizacion = Cotizacion::where('cotizacion_solicitud_id', $solicitud->id)->where('cotizacion_estado_id', $estadoCotizacion->id)->first();
                if (isset($cotizacion)) {
                    $ordenCompra = OrdenCompra::where('oc_cotizacion_id', $cotizacion->id)->where('oc_estado_id', $estadoOrdenCompra->id)->first();
                    $ingreso = Ingreso::where('ingreso_oc_id', $ordenCompra->id)->first();
                    $tipoSolicitud = BodegaProducto::with('ingreso.orden_compra.cotizacion.solicitud.tipo_solicitud','producto','producto.unidad')->where('bp_ingreso_id', $ingreso->id)->get();                                  
                    $productos = BodegaProducto::with('producto','producto.unidad')->where('bp_ingreso_id', $ingreso->id)->get();
                    foreach ($productos as $key => $productosBodega) {   
                        $productosBodega->tipo_solicitud = $tipoSolicitud[$key]['ingreso']['orden_compra']['cotizacion']['solicitud']->tipo_solicitud;;                                         
                        array_push($productosSalida, $productosBodega);
                    }
                }        
            }




            return response()->json(['response' => ['status' => true, 'data' => $productosSalida, 'message' => 'Query success']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 500);
        }
    }

    public function solicitudes($solicitud, $estadoCotizacion, $estadoOrdenCompra)
    {
        $cotizacion = Cotizacion::where('cotizacion_solicitud_id', $solicitud->id)->where('cotizacion_estado_id', $estadoCotizacion->id)->first();
        if (isset($cotizacion)) {
            $ordenCompra = OrdenCompra::where('oc_cotizacion_id', $cotizacion->id)->where('oc_estado_id', $estadoOrdenCompra->id)->first();
            $ingreso = Ingreso::where('ingreso_oc_id', $ordenCompra->id)->first();
            $tipoSolicitud = BodegaProducto::with('ingreso.orden_compra.cotizacion.solicitud.tipo_solicitud','producto','producto.unidad')->where('bp_ingreso_id', $ingreso->id)->get();
            $tipoSolicitud[0]['ingreso']['orden_compra']['cotizacion']['solicitud']->tipo_solicitud;                    
            $productos = BodegaProducto::with('producto','producto.unidad')->where('bp_ingreso_id', $ingreso->id)->get();
            foreach ($productos as $key => $productosBodega) {   
                $productosBodega->tipo_solicitud = $tipoSolicitud[$key]['ingreso']['orden_compra']['cotizacion']['solicitud']->tipo_solicitud;;                                         
                array_push($productosSalida, $productosBodega);
            }
        }  
    }
}
