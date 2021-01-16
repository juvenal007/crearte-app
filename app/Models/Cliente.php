<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    //DEFINIMOS EL NOMBRE DE LA TABLA
    protected $table = 'clientes';
    //DEFINIMOS LA CLAVE PRIMARIA DE LA TABLA, AUTOMATICAMENTE SE LE ASIGNA AUTO INCREMENT
    protected $primaryKey = 'id';

    //CAMPOS QUE NO QUEREMOS QUE SE DEVUELVAN EN LAS CONSULTAS
    protected $hidden = ['created_at','updated_at','deleted_at'];

    //ATRIBUTOS DE LA TABLE
    protected $fillable = [
        'cliente_rut',
        'cliente_dv',
        'cliente_nombre',
        'cliente_apellido_paterno',
        'cliente_apellido_materno',
        'cliente_telefono',
        'cliente_direccion',
        'cliente_genero',
        'cliente_proyecto_id',
        'cliente_estado_id'
    ];

    //RELACIÓN  HACIA PROYECTOS Y ESTADOS
    public function proyecto()
    {
        return $this->belongsTo('App\Models\Proyecto', 'cliente_proyecto_id');
    }
    public function estado()
    {
        return $this->belongsTo('App\Models\Estado', 'cliente_estado_id');
    }


}
