<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalidaProducto extends Model
{
    use HasFactory, SoftDeletes;

    //DEFINIMOS EL NOMBRE DE LA TABLA
    protected $table = 'salida_productos';
    //DEFINIMOS LA CLAVE PRIMARIA DE LA TABLA, AUTOMATICAMENTE SE LE ASIGNA AUTO INCREMENT
    protected $primaryKey = 'id';

    //CAMPOS QUE NO QUEREMOS QUE SE DEVUELVAN EN LAS CONSULTAS
    protected $hidden = ['updated_at','deleted_at'];

    //ATRIBUTOS DE LA TABLE
    protected $fillable = [
        'sp_cantidad',
        'sp_precio',
        'sp_total',
        'sp_producto_id',
        'sp_salida_id',        
        'sp_detalle_solicitud_id',
        'created_at'     
    ];

  
    public function producto()
    {
        return $this->belongsTo('App\Models\Producto', 'sp_producto_id');
    }

    public function salida()
    {
        return $this->belongsTo('App\Models\Salida', 'sp_salida_id');
    }
    public function detalle_solicitud()
    {
        return $this->belongsTo('App\Models\DetalleSolicitud', 'sp_detalle_solicitud_id');
    }
  /*   public function detalle_solicituds()
    {
        return $this->hasMany('App\Models\DetalleSolicitud');
    }
    public function clientes()
    {
        return $this->hasMany('App\Models\Cliente');
    } */
}
