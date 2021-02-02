<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\DetalleSolicitud;
use App\Models\Estado;
use App\Models\Proyecto;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProyectoController extends Controller
{
    const MESSAGES = [
        'required' => 'El atributo :attribute es requerido.',
        'max' => 'El atributo :attribute  no puede exceder los :max caracteres',
        'min' => 'El atributo :attribute  no puede contener menos de los :min caracteres',
        'unique' => 'El atributo de :attribute ya existe',

    ];

    const CUSTOM_ATTRIBUTES = [
        'proyecto_nombre' => 'Nombre',
        'proyecto_direccion' => 'Direccion',
        'proyecto_descripcion' => 'Descripcion',
        'proyecto_telefono_ad' => 'Telefono'
    ];


    public function list($centro_costo_id)
    {
        $proyectos = Proyecto::where('proyecto_centro_costo_id', $centro_costo_id)->get();
        return response()->json(['response' => ['status' => true, 'data' => $proyectos, 'message' => 'Query success']], 200);
    }

    public function list_activo()
    {
        try {
            $estado = Estado::where('estado', 'PROYECTO_ACTIVO')->first();
            $proyecto = Proyecto::with('centro_costo')->where('proyecto_estado_id', $estado->id)->get();
            if ($proyecto->count() <= 0) {
                return response()->json(['response' => ['type_error' => 'not_allowed', 'status' => false, 'data' => [], 'message' => "No se encontraron clientes"]], 404);
            }
            return response()->json(['response' => ['status' => true, 'data' => $proyecto, 'message' => 'Query success']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 500);
        }
        // ID DEL ESTADO ES 10 SIGNIFICA QUE ESTÁ ACTIVO
    }

    public function add(Request $request, $centro_costo_id)
    {
        try {
            $validar = Validator::make($request->data, [
                'proyecto_nombre' => 'required|max:45|min:2',
                'proyecto_direccion' => 'required|max:50|min:2',
                'proyecto_descripcion' => 'required|max:50|min:2',
                'proyecto_telefono_ad' => 'required|max:50|min:2',

            ], ProyectoController::MESSAGES, ProyectoController::CUSTOM_ATTRIBUTES);
            if ($validar->fails()) {
                return response()->json(['response' => ['type_error' => 'validation_error', 'status' => false, 'data' => $validar->errors(), 'message' => 'Validation errors']], 200);
            }
            DB::beginTransaction();

            $estado = Estado::where('estado', 'PROYECTO_ACTIVO')->first();

            $data = [
                'proyecto_nombre' => strtoupper($request->data['proyecto_nombre']),
                'proyecto_direccion' => strtoupper($request->data['proyecto_direccion']),
                'proyecto_descripcion' => strtoupper($request->data['proyecto_descripcion']),
                'proyecto_telefono_ad' => strtoupper($request->data['proyecto_telefono_ad']),
                'proyecto_centro_costo_id' => $centro_costo_id,
                'proyecto_estado_id' => $estado->id
            ];

            $proyecto = new Proyecto($data);
            $proyecto->save();

            $proyectoUltimo = Proyecto::orderBy('created_at', 'DESC')->take(1)->get();

            $datosDetalle = [
                'ds_centro_costo_id' => $centro_costo_id,
                'ds_proyecto_id' => $proyectoUltimo[0]->id,
                'ds_cliente_id' => NULL
            ];

            $detalle_solicitud = new DetalleSolicitud($datosDetalle);
            $detalle_solicitud->save();



            DB::commit();
            return response()->json(['response' => ['status' => true, 'data' => $detalle_solicitud, 'message' => 'Centro de Costos Creado']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 500);
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $validar = Validator::make($request->data, [
                'proyecto_nombre' => 'required|max:100|min:2',
                'proyecto_direccion' => 'required|max:250|min:2',
                'proyecto_descripcion' => 'required|max:250|min:2',
                'proyecto_telefono_ad' => 'max:16|min:6',
            ], ProyectoController::MESSAGES, ProyectoController::CUSTOM_ATTRIBUTES);
            if ($validar->fails()) {
                return response()->json(['response' => ['type_error' => 'validation_error', 'status' => false, 'data' => $validar->errors(), 'message' => 'Validation errors']], 200);
            }

            $proyecto = Proyecto::find($id);
            $proyecto->proyecto_nombre = strtoupper($request->data['proyecto_nombre']);
            $proyecto->proyecto_direccion = strtoupper($request->data['proyecto_direccion']);
            $proyecto->proyecto_descripcion = strtoupper($request->data['proyecto_descripcion']);
            $proyecto->proyecto_telefono_ad = strtoupper($request->data['proyecto_telefono_ad']);
            $proyecto->save();

            //DEVELOP BRANCH


            return response()->json(['response' => ['status' => true, 'data' => $proyecto, 'message' => 'Proyecto Actualizado']], 200);
        } catch (\Illuminate\Database\QueryException $error) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $error, 'message' => 'Error processing']], 500);
        }
    }

    public function add_cliente(Request $request, $id)
    {
        try {
            $proyecto = Proyecto::find($id);
            $proyecto->clientes_id = (int) $request->data;
            $proyecto->save();

            return response()->json(['response' => ['status' => true, 'data' => $proyecto, 'message' => 'Proyecto Actualizado']], 200);
        } catch (\Illuminate\Database\QueryException $error) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $error, 'message' => 'Error processing']], 500);
        }
    }

    public function details($id)
    {
        try {
            $proyecto = Proyecto::with('estado', 'centro_costo')->where('id', $id)->get();
            return response()->json(['response' => ['status' => true, 'data' => $proyecto, 'message' => 'Proyecto Actualizado']], 200);
        } catch (\Illuminate\Database\QueryException $error) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $error, 'message' => 'Error processing']], 500);
        }
    }

    public function delete($id)
    {
        try {

            $proyecto = Proyecto::find($id);
            $clientes = Cliente::where('cliente_proyecto_id', $id)->get();
            
            if (!isset($proyecto)) {
                return response()->json(['response' => ['type_error' => 'entity_not_found', 'status' => false, 'data' => [], 'message' => 'Proyecto consultado no existe']], 400);
            }

            if ($clientes->count() > 0) {
                return response()->json(['response' => ['type_error' => 'not_allowed', 'status' => false, 'data' => [], 'message' => "No es posible eliminar el Proyecto " . $proyecto['proyecto_nombre'] . " ya que tiene Clientes asociados"]], 200);
            }
            $proyecto->delete();

            return response()->json(['response' => ['status' => true, 'data' => $proyecto, 'message' => 'Proyecto Eliminado']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 200);
        }
    }
}
