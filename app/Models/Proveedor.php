<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedor extends Model
{
    use HasFactory, SoftDeletes;

    //DEFINIMOS EL NOMBRE DE LA TABLA
    protected $table = 'proveedors';
    //DEFINIMOS LA CLAVE PRIMARIA DE LA TABLA, AUTOMATICAMENTE SE LE ASIGNA AUTO INCREMENT
    protected $primaryKey = 'id';

    //CAMPOS QUE NO QUEREMOS QUE SE DEVUELVAN EN LAS CONSULTAS
    protected $hidden = ['created_at','updated_at','deleted_at']; 

    //ATRIBUTOS DE LA TABLE
    protected $fillable = [
        'proveedor_rut',
        'proveedor_nombre',
        'proveedor_apellido_paterno',
        'proveedor_apellido_materno',
        'proveedor_direccion',
        'proveedor_telefono',
        'proveedor_razon_social',
        'proveedor_giro',
        'proveedor_ciudad',
        'proveedor_email',   
        'proveedors_id' ,       
    ];

       //RELACIÓN INVERSA HACIA SOLICITUD
       public function productos()
       {
           return $this->hasMany('App\Models\Producto', 'proveedors_id');
       }
}
