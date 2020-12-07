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
            'rut' => 'RUT-'.rand(1000, 4000),
            'nombre' => 'NOMBRE-'.rand(1000, 4000),
            'apellido_paterno' => 'APELLIDO PATERNO-'.rand(1000, 4000),
            'apellido_materno' => 'APELLIDO MATERNO-'.rand(1000, 4000),
            'telefono' => 'TELEFONO-'.rand(1000, 4000),
            'direccion' => 'DIRECCIÓN-'.rand(1000, 4000),
            'genero' => 'GÉNERO-'.rand(1000, 4000),
        ];
    }
}
