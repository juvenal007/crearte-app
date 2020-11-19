<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{


    const MESSAGES = [
        'required' => 'El atributo :attribute es requerido.',
        'max' => 'El atributo :attribute  no puede exceder los :max caracteres',
        'min' => 'El atributo :attribute  no puede contener menos de los :min caracteres',
        'unique' => 'El atributo de :attribute ya existe',

    ];

    const CUSTOM_ATTRIBUTES = [
        'rut' => 'Rut',
        'nombre' => 'Nombre',
        'apellido_paterno' => 'Apellido Paterno',
        'apellido_materno' => 'Apellido Materno',
        'telefono' => 'Telefono',
        'direccion' => 'Dirección',
        'genero' => 'Genero',
    ];

    public function list()
    {
        $cliente = DB::table('clientes')->get();
        return response()->json(['response' => ['status' => true, 'data' => $cliente, 'message' => 'Query success']], 200);
    }

    public function add(Request $request)
    {
        try {
            $validar = Validator::make($request->data, [
                'rut' => 'required|max:45|min:2',
                'nombre' => 'required|max:50|min:2',
            ], ClienteController::MESSAGES, ClienteController::CUSTOM_ATTRIBUTES);
            if ($validar->fails()) {
                return response()->json(['response' => ['type_error' => 'validation_error', 'status' => false, 'data' => $validar->errors(), 'message' => 'Validation errors']], 200);
            }

            $cliente = new Cliente($request->data);
            $cliente->save();

            return response()->json(['response' => ['status' => true, 'data' => $cliente, 'message' => 'Proyecto Creado']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 500);
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $validar = CentroCostoValidate::validateAdd($request);
            if (!$validar->getData()->response->status) {
                return json_encode($validar->getData());
            }
            $centroCosto = CentroCosto::find($id);
            $centroCosto->nombre = $request->data['nombre'];
            $centroCosto->direccion = $request->data['direccion'];
            $centroCosto->save();

            return response()->json(['response' => ['status' => true, 'data' => $centroCosto, 'message' => 'Centro de Costos Actualizado']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 500);
        }
    }

    public function details($id)
    {
        try {
            $cliente = Cliente::where('id', $id)->get();
            return response()->json(['response' => ['status' => true, 'data' => $cliente, 'message' => 'Query success']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 500);
        }
    }
    public function proyecto_details($id)
    {
        try {
            // LLAMA A TODOS LOS CENTROS DE COSTOS CON EL ID DEL CLIENTE
            /* $proyecto = Proyecto::Where('clientes_id', $id)
            ->with('centro_costos')
            ->get(); */

            // LLAMAR A LOS PROYECTOS Y SUS RELACIONES EN FORMA DE ARBOL
            /* $proyecto = Proyecto::with('cliente', 'centro_costos')
            ->where('clientes_id', $id)
            ->get(); */
            $proyecto = Proyecto::with('cliente', 'centro_costos')
            ->where('id', $id) //DEFINIMOS POR QUE VAMOS A BUSCAR
            ->get();

            // INNER JOIN A LA TABLA, MANDA LOS DATOS EN 1 NIVEL DE ARBOL
           /*  $proyecto = DB::table('proyectos')->join('clientes', 'proyectos.clientes_id', '=', 'clientes.id')
                ->select('proyectos.*', 'clientes.*')
                ->get(); */
            /* $cliente = json_decode($proyecto); */
            return response()->json(['response' => ['status' => true, 'data' => $proyecto, 'message' => 'Query success']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 500);
        }
    }
}
