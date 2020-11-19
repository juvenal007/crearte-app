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
            'rut' => Str::random(5),
            'nombre' => Str::random(5),
            'apellido_paterno' => Str::random(5),
            'apellido_materno' => Str::random(5),
            'telefono' => $this->faker->e164PhoneNumber,
            'direccion' => $this->faker->address,
            'genero' => 'Masculino',
        ];
    }
}
