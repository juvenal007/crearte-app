<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Solicitud extends Model
{
    use HasFactory, SoftDeletes;

    //DEFINIMOS EL NOMBRE DE LA TABLA
    protected $table = 'solicituds';
    //DEFINIMOS LA CLAVE PRIMARIA DE LA TABLA, AUTOMATICAMENTE SE LE ASIGNA AUTO INCREMENT
    protected $primaryKey = 'id';

    //CAMPOS QUE NO QUEREMOS QUE SE DEVUELVAN EN LAS CONSULTAS
    protected $hidden = ['created_at','updated_at','deleted_at']; 

    //ATRIBUTOS DE LA TABLE
    protected $fillable = [
        'solicitud_codigo',
        'solicitud_nombre',
        'solicitud_descripcion',
        'solicitud_nombre_solicitante',
        'estados_id',
        'proyectos_id',
        'solicituds_id'
    ];

    //RELACIÓN DIRECTA HACIA PROYECTOS
    public function proyectos()
    {
        return $this->belongsTo('App\Models\Proyecto', 'proyectos_id');
    }

    //RELACIÓN DIRECTA HACIA ESTADOS
    public function estados()
    {
        return $this->belongsTo('App\Models\Estado', 'estados_id');
    }

      //RELACIÓN INVERSA HACIA SOLICITUD_CATALOGO
      public function solicitud_catalogos()
      {
          return $this->hasMany('App\Models\SolicitudCatalogo', 'solicituds_id');
      }
      //RELACIÓN INVERSA HACIA COTIZACION
      public function cotizacions()
      {
          return $this->hasMany('App\Models\Cotizacion', 'solicituds_id');
      }
}
