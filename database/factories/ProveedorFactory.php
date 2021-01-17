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
            'proveedor_rut' => $this->faker->numerify($string = '#######'),
            'proveedor_dv' => $this->faker->numberBetween($min = 1, $max= 9),
            'proveedor_nombre' => 'NOMBRE-'.rand(1000, 4000),
            'proveedor_apellido_paterno' => 'APELLIDO PATERNO-'.rand(1000, 4000),
            'proveedor_apellido_materno' => 'APELLIDO MATERNO-'.rand(1000, 4000),
            'proveedor_direccion' => 'DIRECCIÓN-'.rand(1000, 4000),
            'proveedor_telefono' => 'TELEFONO-'.rand(1000, 4000),
            'proveedor_razon_social' => 'RAZÓN SOCIAL-'.rand(1000, 4000),
            'proveedor_giro' => 'GIRO-'.rand(1000, 4000),
            'proveedor_ciudad' => 'CIUDAD-'.rand(1000, 4000),
            'proveedor_email' => 'E-MAIL-'.rand(1000, 4000),

        ];
    }
}
