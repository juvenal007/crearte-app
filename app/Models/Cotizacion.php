<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cotizacion extends Model
{
    use HasFactory, SoftDeletes;

    //DEFINIMOS EL NOMBRE DE LA TABLA
    protected $table = 'cotizacions';
    //DEFINIMOS LA CLAVE PRIMARIA DE LA TABLA, AUTOMATICAMENTE SE LE ASIGNA AUTO INCREMENT
    protected $primaryKey = 'id';

    //CAMPOS QUE NO QUEREMOS QUE SE DEVUELVAN EN LAS CONSULTAS
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    //ATRIBUTOS DE LA TABLE
    protected $fillable = [
        'cotizacion_codigo',
        'cotizacion_neto',
        'cotizacion_iva',
        'cotizacion_total',
        'cotizacion_fecha_emision',
        'cotizacion_fecha_vigencia',
        'cotizacion_solicitud_id',
        'cotizacion_proveedor_id',
        'cotizacion_estado_id',
    ];

    //RELACIÓN DIRECTA HACIA SOLICITUD
    public function solicitud()
    {
        return $this->belongsTo('App\Models\Solicitud', 'cotizacion_solicitud_id');
    }

    //RELACIÓN DIRECTA HACIA PROVEEDOR
    public function proveedor()
    {
        return $this->belongsTo('App\Models\Proveedor', 'cotizacion_proveedor_id');
    }
    //RELACIÓN DIRECTA HACIA ESTADO
    public function estado()
    {
        return $this->belongsTo('App\Models\Estado', 'cotizacion_estado_id');
    }
    public function cotizacion_productos()
    {
        return $this->hasMany('App\Models\CotizacionProductos');
    }
}
