<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstadoController extends Controller
{
    public function list()
    {
        $estado = DB::table('estados')->get();
        return response()->json(['response' => ['status' => true, 'data' => $estado, 'message' => 'Query success']], 200);
    }
}
