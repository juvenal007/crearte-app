<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('unidads')->insert([
            [
                'unidad_nombre' => 'UNIDAD',
                'unidad_descripcion' => 'Medición del producto por unidades.'
            ],
            [
                'unidad_nombre' => 'METRO',
                'unidad_descripcion' => 'Medición del producto por metros.'
            ],
            [
                'unidad_nombre' => 'KILO',
                'unidad_descripcion' => 'Medición del producto por kilos.'
            ],
            [
                'unidad_nombre' => 'CENTIMETROS',
                'unidad_descripcion' => 'CENTIMETROS'
            ],
            [
                'unidad_nombre' => 'SACO',
                'unidad_descripcion' => 'SACO'
            ],
            [
                'unidad_nombre' => 'ROLLO',
                'unidad_descripcion' => 'ROLLO'
            ],
            [
                'unidad_nombre' => 'TIRA',
                'unidad_descripcion' => 'TIRA.'
            ],
            [
                'unidad_nombre' => 'PLANCHA',
                'unidad_descripcion' => 'PLANCHA'
            ],
            [
                'unidad_nombre' => 'TINETA',
                'unidad_descripcion' => 'TINETA'
            ],
            [
                'unidad_nombre' => 'TUBO',
                'unidad_descripcion' => 'TUBO'
            ],
            [
                'unidad_nombre' => 'TARRO',
                'unidad_descripcion' => 'TARRO'
            ],
            [
                'unidad_nombre' => 'CILINTRO',
                'unidad_descripcion' => 'CILINTRO'
            ],
            [
                'unidad_nombre' => 'M2',
                'unidad_descripcion' => 'M2'
            ],
            [
                'unidad_nombre' => 'GALON',
                'unidad_descripcion' => 'GALON'
            ],
            [
                'unidad_nombre' => 'BOTELLA',
                'unidad_descripcion' => 'BOTELLA'
            ]      
        ]
        );
    }
}
