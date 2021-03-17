<?php

namespace App\Http\Controllers;

use App\Models\Catalogo;
use App\Models\CentroCosto;
use App\Models\Cliente;
use App\Models\DetalleSolicitud;
use App\Models\Estado;
use App\Models\Proyecto;
use App\Models\Solicitud;
use App\Models\SolicitudCatalogo;
use App\Models\TipoSolicitud;
use Faker\Documentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use PDF;

use Illuminate\Support\Str;


class SolicitudController extends Controller
{



    const MESSAGES = [
        'required' => 'El atributo :attribute es requerido.',
        'max' => 'El atributo :attribute  no puede exceder los :max caracteres',
        'min' => 'El atributo :attribute  no puede contener menos de los :min caracteres',
        'unique' => 'El atributo de :attribute ya existe',

    ];

    const CUSTOM_ATTRIBUTES = [
        'solicitud_catalogo_cantidad' => 'Cantidad',
    ];

    public function list()
    {
        $solicituds = Solicitud::where('estado', 'SOLICITUD_ACTIVA')->get();
        return response()->json(['response' => ['status' => true, 'data' => $solicituds, 'message' => 'Query success']], 200);
    }
    public function all_activa()
    {
        try {
            $estado = Estado::where('estado', 'SOLICITUD_ACTIVA')->first();
            $solicituds = Solicitud::with('tipo_solicitud', 'estado', 'solicitud_detalle_solicitud', 'solicitud_detalle_solicitud.cliente', 'solicitud_detalle_solicitud.proyecto', 'solicitud_detalle_solicitud.centro_costo')->where('solicitud_estado_id', $estado->id)->get();
            return response()->json(['response' => ['status' => true, 'data' => $solicituds, 'message' => 'Query success']], 200);
        } catch (\Illuminate\Database\QueryException $error) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $error, 'message' => 'Error processing']], 500);
        }
    }

    public function generatePDF($data)
    {
        $pdf = PDF::loadView('preview', compact('data'), $data);
        $pdf->setPaper('letter', 'portrait');
        /* $archivo = PDF::loadHTML('<h1>hola</h1>')->setPaper('a4', 'landscape')->setWarnings(false)->save('myfile.pdf'); */
        $nombre = date("Y-m-d-H-i-s");
        $final_name = "Fecha-{$nombre}-Solicitud-{$data['carro']['solicitud']->solicitud_codigo}.pdf";

        Storage::disk('documento')->put($final_name, $pdf->output());

        $url = "http://localhost:8000/documento/" . $final_name;
        /* $url = Storage::url($final_name); */

        return $url;
    }


    public function add(Request $request)
    {
        try {
            /*  $validar = Validator::make($request->data, [
                'solicitud_catalogo_cantidad' => 'required|max:45|min:2',
            ], SolicitudController::MESSAGES, SolicitudController::CUSTOM_ATTRIBUTES);
            if ($validar->fails()) {
                return response()->json(['response' => ['type_error' => 'validation_error', 'status' => false, 'data' => $validar->errors(), 'message' => 'Validation errors']], 200);
            } */

            $ultimoId = Solicitud::all()->count();
            $estado = Estado::where('estado', 'SOLICITUD_ACTIVA')->first();
            $tipoSolicitud = TipoSolicitud::find($request->data['solicitud_tipo']);

            $datos = $this->datosTipoSolicitud($request, $tipoSolicitud);

            $datosSolicitud = $this->datosSolicitud($request, $ultimoId, $estado, $tipoSolicitud, $datos);

            // INDICAMOS A MYSQL EL TIPO DE TRANSACCIÓN YA QUE SERÁN SIMULTANEAS
            DB::beginTransaction();

            $solicitud = new Solicitud($datosSolicitud);
            $solicitud->save();

            $carro = $request->data['carro'];

            foreach ($carro as $atributo => $producto) {
                $catalogo = Catalogo::find($producto['id']);
                $datosCarro = [
                    'sc_cantidad' => (int) $producto['cantidad'],
                    'sc_solicitud_id' => $solicitud->id,
                    'sc_catalogo_id' => $catalogo->id
                ];
                $solicitud_catalogo = new SolicitudCatalogo($datosCarro);
                $solicitud_catalogo->save();
            }

            $datos_solicitud_catalogo = SolicitudCatalogo::with('catalogo', 'catalogo.unidad')->where('sc_solicitud_id', $solicitud->id)->get();
            // FECHA INGRESO O GENERADA?
            $fecha = date("d/m/Y H:i:s");

            $datosPdf = [
                'carro' => [
                    'estado' => $estado,
                    'solicitud_tipo' => $tipoSolicitud,
                    'datos_tipo_solicitud' => $datos,
                    'datos_catalogo' => $datos_solicitud_catalogo,
                    'solicitud' => $solicitud,
                    'fecha' => $fecha
                ]
            ];



            $url = $this->generatePDF($datosPdf);

            // GUARDAMOS EN LA BASE DE DATOS
            DB::commit();

            return response()->json(['response' => ['status' => true, 'data' => ['solicitud' => $solicitud, 'pdf' => $url, 'carro' => $datosPdf], 'message' => 'Solicitud creada.']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            // SI FALLA VOLVEMOS AL ESTADO INICIAL
            DB::rollback();
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 500);
        }
    }

    public function details_carro($id)
    {
        try {
           /*  $solicitud = Solicitud::with('solicitud_catalogos', 'tipo_solicitud', 'estado', 'solicitud_detalle_solicitud', 'solicitud_detalle_solicitud.cliente', 'solicitud_detalle_solicitud.proyecto', 'solicitud_detalle_solicitud.centro_costo')->where('id', $id)->first(); */
            /* $solicitud = Solicitud::with('solicitud_catalogos')->where('id', $id)->get(); */
            $solicitud_catalogo = SolicitudCatalogo::with('solicitud', 'catalogo', 'catalogo.unidad')->where('sc_solicitud_id', $id)->get();
            return response()->json(['response' => ['status' => true, 'data' => $solicitud_catalogo, 'message' => 'Proyecto Actualizado']], 200);
        } catch (\Illuminate\Database\QueryException $error) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $error, 'message' => 'Error processing']], 500);
        }
    }

    public function datosTipoSolicitud(Request $request, $tipoSolicitud)
    {
        switch ($tipoSolicitud->ts_nombre) {
            case 'CLIENTE':
                $cliente = Cliente::find($request->data['cliente']['id']);
                $proyecto = Proyecto::find($request->data['cliente']['cliente']['proyecto']['id']);
                $centroCosto = CentroCosto::find($request->data['cliente']['cliente']['proyecto']['centro_costo']['id']);
                $detalle_solicitud = DetalleSolicitud::where('ds_proyecto_id', $proyecto->id)
                    ->where('ds_cliente_id', $cliente->id)
                    ->where('ds_centro_costo_id', $centroCosto->id)
                    ->first();

                return [
                    'cliente' => $cliente,
                    'proyecto' => $proyecto,
                    'centro_costo' => $centroCosto,
                    'detalle_solicitud' => $detalle_solicitud
                ];
                break;

            case 'PROYECTO':
                $proyecto = Proyecto::find($request->data['proyecto']['id']);
                $centroCosto = CentroCosto::find($request->data['proyecto']['proyecto']['centro_costo']['id']);
                $detalle_solicitud = DetalleSolicitud::where('ds_proyecto_id', $proyecto->id)
                    ->where('ds_cliente_id', NULL)
                    ->where('ds_centro_costo_id', $centroCosto->id)
                    ->first();

                return [
                    'proyecto' => $proyecto,
                    'centro_costo' => $centroCosto,
                    'detalle_solicitud' => $detalle_solicitud
                ];
                break;
            case 'CENTRO DE COSTO':
                $centroCosto = CentroCosto::find($request->data['centro_costo']['id']);
                $detalle_solicitud = DetalleSolicitud::where('ds_proyecto_id', NULL)
                    ->where('ds_cliente_id', NULL)
                    ->where('ds_centro_costo_id', $centroCosto->id)
                    ->first();

                return [
                    'centro_costo' => $centroCosto,
                    'detalle_solicitud' => $detalle_solicitud
                ];
                break;
            default:
                $detalle_solicitud = NULL;
                return [
                    'detalle_solicitud' => $detalle_solicitud
                ];
                break;
        }
    }

    public function datosSolicitud(Request $request, $ultimoId, $estado, $tipoSolicitud, $datos)
    {
        if ($ultimoId == 0) {
            if($datos['detalle_solicitud'] == null){
                return [
                    'solicitud_codigo' => 'SO-' . crc32(1),
                    'solicitud_nombre' => $request->data['solicitud_nombre'],
                    'solicitud_descripcion' => $request->data['solicitud_descripcion'],
                    'solicitud_nombre_solicitante' => $request->data['solicitud_nombre_solicitante'],
                    'solicitud_estado_id' => $estado->id,
                    'solicitud_detalle_solicitud_id' =>NULL,
                    'solicitud_tipo_solicitud_id' => $tipoSolicitud->id
                ];
            }else{
                return [
                    'solicitud_codigo' => 'SO-' . crc32(1),
                    'solicitud_nombre' => $request->data['solicitud_nombre'],
                    'solicitud_descripcion' => $request->data['solicitud_descripcion'],
                    'solicitud_nombre_solicitante' => $request->data['solicitud_nombre_solicitante'],
                    'solicitud_estado_id' => $estado->id,
                    'solicitud_detalle_solicitud_id' => $datos['detalle_solicitud']->id,
                    'solicitud_tipo_solicitud_id' => $tipoSolicitud->id
                ];
            }
           
        }

        if (isset($datos['detalle_solicitud'])) {
            return [
                'solicitud_codigo' => 'SO-' . crc32($ultimoId),
                'solicitud_nombre' => $request->data['solicitud_nombre'],
                'solicitud_descripcion' => $request->data['solicitud_descripcion'],
                'solicitud_nombre_solicitante' => $request->data['solicitud_nombre_solicitante'],
                'solicitud_estado_id' => $estado->id,
                'solicitud_detalle_solicitud_id' => $datos['detalle_solicitud']->id,
                'solicitud_tipo_solicitud_id' => $tipoSolicitud->id
            ];
        } else {
            return [
                'solicitud_codigo' => 'SO-' . crc32($ultimoId),
                'solicitud_nombre' => $request->data['solicitud_nombre'],
                'solicitud_descripcion' => $request->data['solicitud_descripcion'],
                'solicitud_nombre_solicitante' => $request->data['solicitud_nombre_solicitante'],
                'solicitud_estado_id' => $estado->id,
                'solicitud_detalle_solicitud_id' => NULL,
                'solicitud_tipo_solicitud_id' => $tipoSolicitud->id
            ];
        }
    }
}
