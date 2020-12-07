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
            'nombre' => 'NOMBRE-PROYECTO-'.rand(1000, 4000),
            'direccion' => 'DIRECCIÓN-'.rand(1000, 4000),
            'descripcion' => 'DESCRIPCIÓN-'.rand(1000, 4000),
            'telefono_ad' => 'TELEFONO-'.rand(1000, 4000),
            'centro_costos_id' => $this->faker->numberBetween($min = 1, $max= 50),
            'clientes_id' => $this->faker->numberBetween($min = 1, $max= 50)
        ];
    }
}
