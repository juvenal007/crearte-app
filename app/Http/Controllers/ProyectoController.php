<?php

namespace App\Http\Controllers;

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
        'nombre' => 'Nombre',
        'direccion' => 'Direccion',
        'descripcion' => 'Descripcion',
        'telefono_ad' => 'Telefono'
    ];


    public function list($centro_costo_id)
    {
        $proyectos = Proyecto::where('centro_costos_id', $centro_costo_id)->get();
        return response()->json(['response' => ['status' => true, 'data' => $proyectos, 'message' => 'Query success']], 200);
    }

    public function add(Request $request)
    {
        try {
            $validar = Validator::make($request->data, [
                'nombre' => 'required|max:45|min:2',
                'direccion' => 'required|max:50|min:2',
                'descripcion' => 'required|max:50|min:2',
                'telefono_ad' => 'required|max:50|min:2',

            ], ProyectoController::MESSAGES, ProyectoController::CUSTOM_ATTRIBUTES);
            if ($validar->fails()) {
                return response()->json(['response' => ['type_error' => 'validation_error', 'status' => false, 'data' => $validar->errors(), 'message' => 'Validation errors']], 200);
            }

            $data = [
                'nombre' => $request->data['nombre'],
                'direccion' => $request->data['direccion'],
                'descripcion' => $request->data['descripcion'],
                'telefono_ad' => $request->data['telefono_ad'],
                'centro_costos_id' => $request->data['centro_costos_id'],
                'clientes_id' => $request->data['clientes_id'],
            ];

            $proyecto = new Proyecto($data);
            $proyecto->save();
            

            return response()->json(['response' => ['status' => true, 'data' => $proyecto, 'message' => 'Proyecto Creado']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 500);
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $validar = Validator::make($request->data, [
                'nombre' => 'required|max:45|min:2',
                'direccion' => 'required|max:50|min:2',
                'descripcion' => 'required|max:50|min:2',
                'telefono_ad' => 'required|max:15|min:8',
            ], ProyectoController::MESSAGES, ProyectoController::CUSTOM_ATTRIBUTES);
            if ($validar->fails()) {
                return response()->json(['response' => ['type_error' => 'validation_error', 'status' => false, 'data' => $validar->errors(), 'message' => 'Validation errors']], 200);
            }

            $proyecto = Proyecto::find($id);
            $proyecto->nombre = $request->data['nombre'];
            $proyecto->direccion = $request->data['direccion'];
            $proyecto->descripcion = $request->data['descripcion'];
            $proyecto->telefono_ad = $request->data['telefono_ad'];
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
           $proyecto = Proyecto::with( 'clientes', 'centro_costos')->where('id', $id)->get();
            return response()->json(['response' => ['status' => true, 'data' => $proyecto, 'message' => 'Proyecto Actualizado']], 200);
        } catch (\Illuminate\Database\QueryException $error) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $error, 'message' => 'Error processing']], 500);
        }
    }

    public function delete($id)
    {
        try {
            $proyectos = Solicitud::where('proyectos_id', $id)->get();

            if (!$proyectos) {
                return response()->json(['response' => ['type_error' => 'entity_not_found', 'status' => false, 'data' => [], 'message' => 'Proyecto consultado no existe']], 400);
            }

            if ($proyectos->count() > 0) {
                return response()->json(['response' => ['type_error' => 'not_allowed', 'status' => false, 'data' => [], 'message' => "No es posible eliminar el Proyecto " . $proyectos[0]['nombre'] . " ya que tiene Solicitudes asociadas"]], 200);
            }

            $proyectos = Proyecto::where('id',$id);
            $proyectos->delete();

            return response()->json(['response' => ['status' => true, 'data' => $proyectos, 'message' => 'Proyecto Eliminado']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 200);
        }
    }
}
