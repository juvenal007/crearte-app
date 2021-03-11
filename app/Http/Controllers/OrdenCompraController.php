<?php

namespace App\Http\Controllers;

use App\Models\CotizacionProducto;
use App\Models\Estado;
use App\Models\OrdenCompra;
use Illuminate\Http\Request;

class OrdenCompraController extends Controller
{
    public function all_activa()
    {
        try {
            $estado = Estado::where('estado', 'ORDEN_ACTIVA')->first();
            $ordenCompra = OrdenCompra::with('cotizacion','estado','cotizacion.proveedor', 'cotizacion.solicitud')->where('oc_estado_id', $estado->id)->get();
            return response()->json(['response' => ['status' => true, 'data' => $ordenCompra, 'message' => 'Lista de Ordenes']], 200);
        } catch (\Illuminate\Database\QueryException $error) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $error, 'message' => 'Error processing']], 500);
        }
    }
    public function all_terminada()
    {
        try {
            $estado = Estado::where('estado', 'ORDEN_TERMINADA')->first();
            $ordenCompra = OrdenCompra::with('cotizacion','estado','cotizacion.proveedor', 'cotizacion.solicitud')->where('oc_estado_id', $estado->id)->get();

            $tablaGastos = [];
            $totalGeneral = 0;
            foreach ($ordenCompra as $index => $orden) {
                $nuevoGasto = [
                    'codigo_cotizacion' => $orden['oc_guia_despacho'],
                    'neto' => "$ ".number_format($orden['cotizacion']['cotizacion_neto'], NULL, ",", "."),
                    'iva' => "$ ".number_format($orden['cotizacion']['cotizacion_iva'], NULL, ",", "."),
                    'total' => "$ ".number_format($orden['cotizacion']['cotizacion_total'], NULL, ",", "."),
                    'proveedor' => $orden['cotizacion']['proveedor']['proveedor_nombre'],
                    'proveedor_telefono' => $orden['cotizacion']['proveedor']['proveedor_telefono'],
                    'solicitud_codigo' => $orden['cotizacion']['solicitud']['solicitud_codigo'],
                    'solicitud_nombre' => $orden['cotizacion']['solicitud']['solicitud_nombre'],
                    'solicitud_nombre_solicitante' => $orden['cotizacion']['solicitud']['solicitud_nombre_solicitante'],
                ];
                $totalGeneral += $orden['cotizacion']['cotizacion_total'];
                array_push($tablaGastos, $nuevoGasto);
            }

            $totalGeneral = [
                'total' => "$ ".number_format($totalGeneral, NULL, ",", ".")
            ];
            array_push($tablaGastos, $totalGeneral);
            return response()->json(['response' => ['status' => true, 'data' => $tablaGastos, 'totalGeneral' => $totalGeneral , 'message' => 'Query success']], 200);
        } catch (\Illuminate\Database\QueryException $error) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $error, 'message' => 'Error processing']], 500);
        }
    }
    public function details_carro($id)
    {
        try {
           /*  $solicitud = Solicitud::with('solicitud_catalogos', 'tipo_solicitud', 'estado', 'solicitud_detalle_solicitud', 'solicitud_detalle_solicitud.cliente', 'solicitud_detalle_solicitud.proyecto', 'solicitud_detalle_solicitud.centro_costo')->where('id', $id)->first(); */
            /* $solicitud = Solicitud::with('solicitud_catalogos')->where('id', $id)->get(); */
            $cotizacionProductos = CotizacionProducto::with('producto', 'producto.unidad')->where('cp_cotizacion_id', $id)->get();
            return response()->json(['response' => ['status' => true, 'data' => $cotizacionProductos, 'message' => 'Cotizacion Productos']], 200);
        } catch (\Illuminate\Database\QueryException $error) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $error, 'message' => 'Error processing']], 500);
        }
    }
}
