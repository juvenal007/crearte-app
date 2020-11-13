<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
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
        'direccion' => 'Direccion'
    ];


    public function list($centro_costo_id)
    {
        $proyectos = Proyecto::where('centro_costos_id', $centro_costo_id)->get();
        return response()->json(['response' => ['status' => true, 'data' => $proyectos, 'msg' => 'Query success']], 200);
    }

    public function add(Request $request, $centro_costo_id)
    {
        try {
            $validar = Validator::make($request->data, [
                'nombre' => 'required|max:45|min:2',
                'direccion' => 'required|max:50|min:2',
            ], ProyectoController::MESSAGES, ProyectoController::CUSTOM_ATTRIBUTES);
            if ($validar->fails()) {
                return response()->json(['response' => ['type_error' => 'validation_error', 'status' => false, 'data' => $validar->errors(), 'message' => 'Validation errors']], 200);
            }

            $proyecto = new Proyecto($request->data);
            $proyecto->centro_costos_id = $centro_costo_id;
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
            $proyecto->telefono_ad = $request->data['telefon_ad'];
            $proyecto->save();

            //DEVELOP BRANCH
            

            return response()->json(['response' => ['status' => true, 'data' => $proyecto, 'message' => 'Proyecto Actualizado']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 500);
        }
    }
}
