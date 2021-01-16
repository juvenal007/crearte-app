<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ClienteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cliente::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cliente_rut' => $this->faker->numerify($string = '#######'),
            'cliente_dv' => $this->faker->numberBetween($min = 1, $max= 9),
            'cliente_nombre' => 'NOMBRE-'.rand(1000, 4000),
            'cliente_apellido_paterno' => 'APELLIDO PATERNO-'.rand(1000, 4000),
            'cliente_apellido_materno' => 'APELLIDO MATERNO-'.rand(1000, 4000),
            'cliente_telefono' => 'TELEFONO-'.rand(1000, 4000),
            'cliente_direccion' => 'DIRECCIÓN-'.rand(1000, 4000),
            'cliente_genero' => 'GÉNERO-'.rand(1000, 4000),
            'cliente_proyecto_id' => $this->faker->numberBetween($min = 1, $max= 50),
            'cliente_estado_id' => 10
        ];
    }
}
