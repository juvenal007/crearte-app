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
            UnidadSeeder::class,
           /*  ProveedorSeeder::class, */
           /*  CatalogoSeeder::class, */
            UserSeeder::class,
            EstadoSeeder::class,
            /* CentroCostoSeeder::class, */
            /* EstadoSeeder::class, */
         /*    ProductoSeeder::class, */
            /* ProyectoSeeder::class, */
            /* ClienteSeeder::class, */
            TipoSolicitudSeeder::class,

            /* SolicitudSeeder::class, */
            /* SolicitudCatalogoSeeder::class */
        ]);
    }
}
