<?php

namespace Database\Factories;

use App\Models\Estado;
use App\Models\Proyecto;
use Illuminate\Database\Eloquent\Factories\Factory;


class ProyectoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Proyecto::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $estado = Estado::where('estado', 'PROYECTO_ACTIVO')->first();
        return [
            'proyecto_nombre' => 'NOMBRE-PROYECTO-'.rand(1000, 4000),
            'proyecto_direccion' => 'DIRECCIÓN-'.rand(1000, 4000),
            'proyecto_descripcion' => 'DESCRIPCIÓN-'.rand(1000, 4000),
            'proyecto_telefono_ad' => 'TELEFONO-'.rand(1000, 4000),
            'proyecto_centro_costo_id' => $this->faker->numberBetween($min = 1, $max= 10),
            'proyecto_estado_id' => $estado->id
        ];
    }
}
