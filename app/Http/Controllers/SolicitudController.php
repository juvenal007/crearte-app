<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use App\Models\Solicitud;
use App\Models\SolicitudCatalogo;
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
        $solicituds = DB::table('solicituds')->get();
        return response()->json(['response' => ['status' => true, 'data' => $solicituds, 'message' => 'Query success']], 200);
    }
  /*   public function all()
    {
        $solicitudes = Solicitud::with('proyectos')
            ->where('estados_id',1) //DEFINIMOS POR QUE VAMOS A BUSCAR
            ->get();
        return response()->json(['response' => ['status' => true, 'data' => $solicitudes, 'message' => 'Query success']], 200);
    } */

    public function generatePDF()
    {
        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y')
        ];
        $pdf = PDF::loadView('preview', $data);
        /* $archivo = PDF::loadHTML('<h1>hola</h1>')->setPaper('a4', 'landscape')->setWarnings(false)->save('myfile.pdf'); */
        $filename = uniqid('solicitud-', true) . '.';
        $nombre = date("Y-m-d-H-i-s");
        $final_name = "Solicitud-{$nombre}.pdf";

        Storage::disk('solicitud')->put($final_name, $pdf->output());
        $url = "http://localhost:8000/solicitudes/".$final_name;
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
            $estado = Estado::where('estado', 'SOLICITUD_ACTIVA');

            if($ultimoId == 0)
            {
                $datos = [
                    'solicitud_codigo' => crc32(1),
                    'solicitud_nombre' => $request->data['solicitud_nombre'],
                    'solicitud_descripcion' => $request->data['solicitud_descripcion'],
                    'solicitud_nombre_solicitante' => $request->data['solicitud_nombre_solicitante'],
                    'solicitud_estado_id' => $estado->id,
                    'solicitud_detalle_solicitud_id' => $request->data['proyecto']['id'],
                ];
            }

          /*   $solicitud = $request->data;

            // INDICAMOS A MYSQL EL TIPO DE TRANSACCIÓN YA QUE SERÁN SIMULTANEAS
            DB::beginTransaction();

            $solicitud = new Solicitud($datos);
            $solicitud->save();

            $carro = $request->data['carro'];

            foreach ($carro as $atributo => $producto) {
                $datos = [
                    'solicitud_catalogo_cantidad' => (int) $producto['cantidad'],
                    'solicituds_id' => $solicitud->id,
                    'catalogos_id' => $producto['id']
                ];
                $solicitud_catalogo = new SolicitudCatalogo($datos);
                $solicitud_catalogo->save();
            }

              $url = $this->generatePDF(); */





            // GUARDAMOS EN LA BASE DE DATOS
        /*     DB::commit(); */

            return response()->json(['response' => ['status' => true, 'data' => ['solicitud' => $ultimoId, 'pdf' => $ultimoId, 'carro' => $ultimoId], 'message' => 'Datos Creados']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            // SI FALLA VOLVEMOS AL ESTADO INICIAL
          /*   DB::rollback(); */
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 500);
        }
    }

    public function details($id)
    {
        try {
           $proyecto = Proyecto::with( 'clientes', 'centro_costos')->where('id', $id)->get();
            return response()->json(['response' => ['status' => true, 'data' => $proyecto, 'message' => 'Proyecto Actualizado']], 200);
        } catch (\Illuminate\Database\QueryException $error) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $error, 'message' => 'Error processing']], 500);
        }
    }
}
