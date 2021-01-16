<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // ORDENAR SEEDER DE ACUERDO A LAS RELACIONES, ES DECIR
        // DESDE LOS MANTENEDORES HACIA LAS TABLAS RELACIONADAS
        $this->call([
            CatalogoSeeder::class,
            UserSeeder::class,
            EstadoSeeder::class,
            CentroCostoSeeder::class,
            EstadoSeeder::class,
            ProveedorSeeder::class,
            ProductoSeeder::class,
            ProyectoSeeder::class,
            ClienteSeeder::class,
            /* SolicitudSeeder::class, */
            SolicitudCatalogoSeeder::class
        ]);
    }
}
