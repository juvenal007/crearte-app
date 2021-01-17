<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory, SoftDeletes;

    //DEFINIMOS EL NOMBRE DE LA TABLA
    protected $table = 'productos';
    //DEFINIMOS LA CLAVE PRIMARIA DE LA TABLA, AUTOMATICAMENTE SE LE ASIGNA AUTO INCREMENT
    protected $primaryKey = 'id';

    //CAMPOS QUE NO QUEREMOS QUE SE DEVUELVAN EN LAS CONSULTAS
    protected $hidden = ['created_at','updated_at','deleted_at'];

    //ATRIBUTOS DE LA TABLE
    protected $fillable = [
        'producto_material',
        'producto_descripcion',
        'producto_unidad_id',
        'producto_proveedor_id'
    ];

        //RELACIÓN DIRECTA HACIA PROVEEDOR
        public function proveedor()
        {
            return $this->belongsTo('App\Models\Proveedor', 'producto_proveedor_id');
        }

        public function catalogos()
        {
            return $this->hasMany('App\Models\SolicitudCatalogo');
        }


}

