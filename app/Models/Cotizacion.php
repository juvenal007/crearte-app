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
        'cotizacion_fehca_vigencia',
        'solicituds_id',
        'proveedors_id',
        'estados_id',
    ];

    //RELACIÓN DIRECTA HACIA SOLICITUD
    public function solicituds()
    {
        return $this->belongsTo('App\Models\Solicitud', 'solicituds_id');
    }

    //RELACIÓN DIRECTA HACIA PROVEEDOR
    public function proveedors()
    {
        return $this->belongsTo('App\Models\Proveedor', 'proveedors_id');
    }
    //RELACIÓN DIRECTA HACIA ESTADO
    public function estados()
    {
        return $this->belongsTo('App\Models\Estado', 'estados_id');
    }
}
