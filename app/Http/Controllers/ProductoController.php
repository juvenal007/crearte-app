<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function list()
    {
        $productos = DB::table('productos')->get();
        return response()->json(['response' => ['status' => true, 'data' => $productos, 'message' => 'Query success']], 200);
    }
}
