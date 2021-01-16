<?php

namespace Database\Factories;

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
        return [
            'proyecto_nombre' => 'NOMBRE-PROYECTO-'.rand(1000, 4000),
            'proyecto_direccion' => 'DIRECCIÓN-'.rand(1000, 4000),
            'proyecto_descripcion' => 'DESCRIPCIÓN-'.rand(1000, 4000),
            'proyecto_telefono_ad' => 'TELEFONO-'.rand(1000, 4000),
            'proyecto_centro_costo_id' => $this->faker->numberBetween($min = 1, $max= 50),
            'proyecto_estado_id' => 8
        ];
    }
}
