<?php

namespace Database\Factories;

use App\Models\Proveedor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProveedorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Proveedor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'proveedor_rut' => Str::random(5),
            'proveedor_nombre' => Str::random(5),
            'proveedor_apellido_paterno' => Str::random(5),
            'proveedor_apellido_materno' => Str::random(5),
            'proveedor_direccion' => $this->faker->address,
            'proveedor_telefono' => $this->faker->e164PhoneNumber,
            'proveedor_razon_social' => $this->faker->text(15),
            'proveedor_giro' => $this->faker->text(10),
            'proveedor_ciudad' => $this->faker->text(8),
            'proveedor_email' => $this->faker->text(13)
            
        ];
    }
}
