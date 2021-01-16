<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estado extends Model
{
    use HasFactory, SoftDeletes;

    //DEFINIMOS EL NOMBRE DE LA TABLA
    protected $table = 'estados';
    //DEFINIMOS LA CLAVE PRIMARIA DE LA TABLA, AUTOMATICAMENTE SE LE ASIGNA AUTO INCREMENT
    protected $primaryKey = 'id';

    //CAMPOS QUE NO QUEREMOS QUE SE DEVUELVAN EN LAS CONSULTAS
    protected $hidden = ['created_at','updated_at','deleted_at'];

    //ATRIBUTOS DE LA TABLE
    protected $fillable = [
        'estado',
        'estado_descripcion',
    ];

    //RELACIÓN INVERSA HACIA PROYECTO
    public function proyectos()
    {
        return $this->hasMany('App\Models\Proyecto');
    }
    public function clientes()
    {
        return $this->hasMany('App\Models\Cliente');
    }

    //RELACION INVERSA HACIA SOLICITUDS
    public function solicituds()
    {
        return $this->hasMany('App\Models\Solicitud');
    }

    //RELACION INVERSA HACIA SOLICITUDS
    public function cotizacions()
    {
        return $this->hasMany('App\Models\Cotizacions');
    }
 /*    public function orden_compra()
    {
        return $this->hasMany('App\Models\OrdenCompra');
    } */
}
