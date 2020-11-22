<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use App\Models\SolicitudCatalogo;
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

            $solicitud = $request->data;
            $datos = [
                'solicitud_codigo' => Str::random(3) . "-" . Str::random(7),
                'solicitud_nombre' => Str::random(10),
                'solicitud_descripcion' => Str::random(50),
                'solicitud_nombre_solicitante' => $request->data['solicitud_nombre_solicitante'],
                'estados_id' => 1,
                'proyectos_id' => $request->data['proyecto']['id'],
            ];
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

              $url = $this->generatePDF();

           



            // GUARDAMOS EN LA BASE DE DATOS
            DB::commit();

            return response()->json(['response' => ['status' => true, 'data' => ['solicitud' => $solicitud, 'pdf' => $url, 'carro' => $carro], 'message' => 'Proyecto Creado']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            // SI FALLA VOLVEMOS AL ESTADO INICIAL
            DB::rollback();
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 500);
        }
    }
}
