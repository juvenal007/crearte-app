<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdenCompra extends Model
{
    use HasFactory, SoftDeletes;

    //DEFINIMOS EL NOMBRE DE LA TABLA
    protected $table = 'orden_compras';
    //DEFINIMOS LA CLAVE PRIMARIA DE LA TABLA, AUTOMATICAMENTE SE LE ASIGNA AUTO INCREMENT
    protected $primaryKey = 'id';

    //CAMPOS QUE NO QUEREMOS QUE SE DEVUELVAN EN LAS CONSULTAS
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    //ATRIBUTOS DE LA TABLE
    protected $fillable = [
        'oc_guia_despacho',
        'oc_cotizacion_id',
        'oc_estado_id'        
    ];

    public function cotizacion()
    {
        return $this->belongsTo('App\Models\Cotizacion', 'oc_cotizacion_id');
    }
   
    //RELACIÓN DIRECTA HACIA ESTADO
    public function estado()
    {
        return $this->belongsTo('App\Models\Estado', 'oc_estado_id');
    } 
    public function ingresos()
    {
        return $this->hasMany('App\Models\Ingreso');
    } 
}
