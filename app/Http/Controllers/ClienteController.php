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
        'cliente_rut' => 'Rut',
        'cliente_nombre' => 'Nombre',
        'cliente_apellido_paterno' => 'Apellido Paterno',
        'cliente_apellido_materno' => 'Apellido Materno',
        'cliente_telefono' => 'Telefono',
        'cliente_direccion' => 'Dirección',
        'cliente_genero' => 'Genero',
    ];

    public function list()
    {
        $cliente = Cliente::all();
        return response()->json(['response' => ['status' => true, 'data' => $cliente, 'message' => 'Query success']], 200);
    }

    public function add(Request $request)
    {
        try {
            $validar = Validator::make($request->data, [
                'cliente_rut' => 'required|max:45|min:2',
                'cliente_nombre' => 'required|max:50|min:2',
                'cliente_apellido_paterno' => 'required|max:100|min:2',
                'cliente_apellido_materno' => 'required|max:100|min:2',
                'cliente_telefono' => 'required|max:30|min:2',
                'cliente_direccion' => 'required|max:100|min:2',
                'cliente_genero' => 'required|max:15|min:2',
            ], ClienteController::MESSAGES, ClienteController::CUSTOM_ATTRIBUTES);
            if ($validar->fails()) {
                return response()->json(['response' => ['type_error' => 'validation_error', 'status' => false, 'data' => $validar->errors(), 'message' => 'Validation errors']], 200);
            }

            $cliente = new Cliente($request->data);
            $cliente->save();

            return response()->json(['response' => ['status' => true, 'data' => $cliente, 'message' => 'Cliente Creado']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 500);
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $validar = Validator::make($request->data, [
                'cliente_rut' => 'required|max:45|min:2',
                'cliente_nombre' => 'required|max:50|min:2',
                'cliente_apellido_paterno' => 'required|max:100|min:2',
                'cliente_apellido_materno' => 'required|max:100|min:2',
                'cliente_telefono' => 'required|max:30|min:2',
                'cliente_direccion' => 'required|max:100|min:2',
                'cliente_genero' => 'required|max:15|min:2',
            ], ClienteController::MESSAGES, ClienteController::CUSTOM_ATTRIBUTES);
            if ($validar->fails()) {
                return response()->json(['response' => ['type_error' => 'validation_error', 'status' => false, 'data' => $validar->errors(), 'message' => 'Validation errors']], 200);
            }
            $cliente = Cliente::find($id);
            $cliente->rut = $request->data['cliente_rut'];
            $cliente->nombre = $request->data['cliente_nombre'];
            $cliente->apellido_paterno = $request->data['cliente_apellido_paterno'];
            $cliente->apellido_materno = $request->data['cliente_apellido_materno'];
            $cliente->telefono = $request->data['cliente_telefono'];
            $cliente->direccion = $request->data['cliente_direccion'];
            $cliente->genero = $request->data['cliente_genero'];
            $cliente->save();

            return response()->json(['response' => ['status' => true, 'data' => $cliente, 'message' => 'Cliente Actualizado']], 200);
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
            $proyecto = Proyecto::with('proyecto_cliente', 'proyecto_centro_costo')
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

    public function delete($id)
    {
        try {
            $cliente = Proyecto::where('proyecto_cliente_id', $id)->get();

            if (!$cliente) {
                return response()->json(['response' => ['type_error' => 'entity_not_found', 'status' => false, 'data' => [], 'message' => 'Cliente consultado no existe']], 400);
            }

            if ($cliente->count() > 0) {
                return response()->json(['response' => ['type_error' => 'not_allowed', 'status' => false, 'data' => [], 'message' => "No es posible eliminar el Cliente " . $cliente[0]['nombre'] . " ya que tiene Proyectos asociadas"]], 200);
            }

            $cliente = Cliente::where('id',$id);
            $cliente->delete();

            return response()->json(['response' => ['status' => true, 'data' => $cliente, 'message' => 'Cliente Eliminado']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 200);
        }
    }
}
