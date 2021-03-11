<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingreso extends Model
{
    use HasFactory, SoftDeletes;

    //DEFINIMOS EL NOMBRE DE LA TABLA
    protected $table = 'ingresos';
    //DEFINIMOS LA CLAVE PRIMARIA DE LA TABLA, AUTOMATICAMENTE SE LE ASIGNA AUTO INCREMENT
    protected $primaryKey = 'id';

    //CAMPOS QUE NO QUEREMOS QUE SE DEVUELVAN EN LAS CONSULTAS
    protected $hidden = ['created_at','updated_at','deleted_at'];

    //ATRIBUTOS DE LA TABLE
    protected $fillable = [
        'ingreso_oc_id',
        'ingreso_bodega_id',
        'ingreso_ds_id'      
    ];

        //RELACIÓN INVERSA HACIA CATALOGO
        public function orden_compra()
        {
            return $this->belongsTo('App\Models\OrdenCompra', 'ingreso_oc_id');
        }
        public function bodega()
        {
            return $this->belongsTo('App\Models\Bodega', 'ingreso_bodega_id');
        }
        public function detalle_solicitud()
        {
            return $this->belongsTo('App\Models\DetalleSolicitud', 'ingreso_ds_id');
        }
        public function bodega_productos()
        {
            return $this->hasMany('App\Models\BodegaProducto');
        }



}

