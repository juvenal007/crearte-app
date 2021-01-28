<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use App\Models\CotizacionProducto;
use App\Models\Estado;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Solicitud;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use NumberFormatter;

class CotizacionController extends Controller
{

    public function generatePDF($data)
    {
        $pdf = PDF::loadView('ordenCompra', compact('data'), $data);
        $pdf->setPaper('letter', 'portrait');
        /* $archivo = PDF::loadHTML('<h1>hola</h1>')->setPaper('a4', 'landscape')->setWarnings(false)->save('myfile.pdf'); */
        $filename = uniqid('orden-compra-', true) . '.';
        $nombre = date("Y-m-d-H-i-s");
        $final_name = "OrdenCompra-{$nombre}.pdf";

        Storage::disk('ordenesCompra')->put($final_name, $pdf->output());

        $url = "http://localhost:8000/ordenesCompra/" . $final_name;
       /*  $url = Storage::url($final_name); */

        return $url;
    }
    public function add(request $request)
    {
        try {
            DB::beginTransaction();

            $estado = Estado::where('estado', 'COTIZACION_ACTIVA')->first();

            $datosCotizacion = [
                'cotizacion_codigo' => $request->data['cotizacion_codigo'],
                'cotizacion_neto' => $request->data['cotizacion_neto'],
                'cotizacion_iva' => $request->data['cotizacion_iva'],
                'cotizacion_total' => $request->data['cotizacion_total'],
                'cotizacion_fecha_emision' => $request->data['cotizacion_fecha_emision'],
                'cotizacion_fecha_vigencia' => $request->data['cotizacion_fecha_vigencia'],
                'cotizacion_solicitud_id' => $request->data['cotizacion_solicitud_id'],
                'cotizacion_proveedor_id' => $request->data['cotizacion_proveedor_id'],
                'cotizacion_estado_id' => $estado->id,
            ];

            $cotizacion = new Cotizacion($datosCotizacion);
            $cotizacion->save();

            $carroCatalogo = $request->data['nuevoCarro'];

            $arr = [];

            $productoModificado = '';

            foreach ($carroCatalogo as $atributo => $catalogo) {
                $producto = Producto::where('producto_material', $catalogo['catalogo_material'])
                    ->where('producto_descripcion', $catalogo['catalogo_descripcion'])
                    ->where('producto_unidad_id', $catalogo['catalogo_unidad'])
                    ->where('producto_proveedor_id', $request->data['cotizacion_proveedor_id'])
                    ->first();

                if (!(isset($producto))) {
                    $datosProductoNuevo = [
                        'producto_material' => $catalogo['catalogo_material'],
                        'producto_descripcion' => $catalogo['catalogo_descripcion'],
                        'producto_precio' => $catalogo['precio'],
                        'producto_proveedor_id' => $request->data['cotizacion_proveedor_id'],
                        'producto_unidad_id' => $catalogo['catalogo_unidad']
                    ];

                    $productoModificado = new Producto($datosProductoNuevo);
                    $productoModificado->save();
                } else {
                    $productoModificado = Producto::find($producto->id);
                    $productoModificado->producto_precio = $catalogo['precio'];
                    $productoModificado->save();
                }

                $datosCotizacionProducto = [
                    'cp_cantidad' => intval($catalogo['cantidad']),
                    'cp_precio' => floatval($catalogo['precio']),
                    'cp_total' => intval($catalogo['total']),
                    'cp_cotizacion_id' => $cotizacion->id,
                    'cp_producto_id' => $productoModificado->id
                ];

                $cotizacioProducto = new CotizacionProducto($datosCotizacionProducto);
                $cotizacioProducto->save();
            }

            $datos_solicitud_producto = CotizacionProducto::with('producto', 'producto.unidad')->where('cp_cotizacion_id', $cotizacion->id)->get();
            /* $proveedor = Proveedor::find($cotizacion->cotizacion_proveedor_id); */
            $solicitud = Solicitud::with('tipo_solicitud')->where('id', $request->data['cotizacion_solicitud_id'])->first();
            $cotizacion = Cotizacion::with('proveedor')->find($cotizacion->id);
            // FECHA INGRESO O GENERADA?
            $fecha = date("d/m/Y H:i:s");

            $datosPdf = [
                'carro' => [
                    'estado' => $estado,
                    'datos_producto' => $datos_solicitud_producto,
                    'solicitud' => $solicitud,
                    'cotizacion' => $cotizacion,
                    'fecha' => $fecha,
                    'neto' => number_format($cotizacion['cotizacion_neto'],NULL, ",", "."),
                    'iva' => number_format($cotizacion['cotizacion_iva'],NULL, ",", "."),
                    'total' => number_format($cotizacion['cotizacion_total'],NULL, ",", "."),
                ]
            ];

            $url = $this->generatePDF($datosPdf);
            DB::commit();

            return response()->json(['response' => ['status' => true, 'data' => ['cotizacion' => $datosPdf, 'pdf' => $url], 'message' => 'Orden de compra generada.']], 200);
        } catch (\Illuminate\Database\QueryException $error) {
            DB::rollback();
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $error, 'message' => 'Error processing']], 500);
        }
    }
}
