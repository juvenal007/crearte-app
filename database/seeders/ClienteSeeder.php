<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clientes')->insert([
            'rut' => 'S/N',
            'nombre' => 'S/N',
            'apellido_paterno' => 'S/N',
            'apellido_materno' => 'S/N',
            'telefono' => 'S/N',
            'direccion' => 'S/N',
            'genero' => 'S/N'
        ]);

        Cliente::factory()
            ->times(50)            
            ->create();
    }
}
