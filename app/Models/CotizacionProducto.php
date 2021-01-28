<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CotizacionProducto extends Model
{
    use HasFactory, SoftDeletes;

    //DEFINIMOS EL NOMBRE DE LA TABLA
    protected $table = 'cotizacion_productos';
    //DEFINIMOS LA CLAVE PRIMARIA DE LA TABLA, AUTOMATICAMENTE SE LE ASIGNA AUTO INCREMENT
    protected $primaryKey = 'id';

    //CAMPOS QUE NO QUEREMOS QUE SE DEVUELVAN EN LAS CONSULTAS
    protected $hidden = ['created_at','updated_at','deleted_at'];

    //ATRIBUTOS DE LA TABLE
    protected $fillable = [
        'cp_cantidad',
        'cp_precio',
        'cp_total',
        'cp_cotizacion_id',
        'cp_producto_id'
    ];

        //RELACIÓN DIRECTA HACIA PROVEEDOR
        public function cotizacion()
        {
            return $this->belongsTo('App\Models\Cotizacion', 'cp_cotizacion_id');
        }

        public function producto()
        {
            return $this->belongsTo('App\Models\Producto', 'cp_producto_id');
        }
      



}

