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
        ]
        );
    }
}
