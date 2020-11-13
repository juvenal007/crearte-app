<?php

namespace App\Validate;

use App\Models\CentroCosto;
use Illuminate\Http\Request;


use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;



class CentroCostoValidate
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

    public function __construct()
    {
    }

    public static function validateAdd(Request $request)
    {        // $request->data() EN LA RUTA DEL END POINT DE LA API    
        $validar = Validator::make($request->data, [
            'nombre' => 'required|max:45|min:2',
            'direccion' => 'required|max:50|min:2',
        ], CentroCostoValidate::MESSAGES, CentroCostoValidate::CUSTOM_ATTRIBUTES);
        if ($validar->fails()) {
            return response()->json(['response' => ['type_error' => 'validation_error', 'status' => false, 'data' => $validar->errors(), 'message' => 'Validation errors']], 200);
        }        
        return response()->json(['response' => ['status' => true, ]], 200);  
    }
}
