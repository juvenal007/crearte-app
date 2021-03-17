<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BodegaProducto extends Model
{
    use HasFactory, SoftDeletes;

    //DEFINIMOS EL NOMBRE DE LA TABLA
    protected $table = 'bodega_productos';
    //DEFINIMOS LA CLAVE PRIMARIA DE LA TABLA, AUTOMATICAMENTE SE LE ASIGNA AUTO INCREMENT
    protected $primaryKey = 'id';

    //CAMPOS QUE NO QUEREMOS QUE SE DEVUELVAN EN LAS CONSULTAS
    protected $hidden = ['deleted_at'];

    //ATRIBUTOS DE LA TABLE
    protected $fillable = [
        'bp_cantidad',
        'bp_precio',
        'bp_total',
        'bp_existencia',        
        'bp_producto_id',        
        'bp_ingreso_id', 
        'created_at',
        'updated_at'
    ];

        //RELACIÓN DIRECTA HACIA PROVEEDOR
        public function ingreso()
        {
            return $this->belongsTo('App\Models\Ingreso', 'bp_ingreso_id');
        }

        public function producto()
        {
            return $this->belongsTo('App\Models\Producto', 'bp_producto_id');
        }     

}

