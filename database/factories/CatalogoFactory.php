<?php

namespace Database\Factories;

use App\Models\Catalogo;
use Illuminate\Database\Eloquent\Factories\Factory;

class CatalogoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Catalogo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'catalogo_material' => 'MATERIAL-'.rand(1000, 4000),
            'catalogo_descripcion' => 'DESCRIPCIÓN-'.rand(1000, 4000),
            'catalogo_unidad' => 'UNIDAD-'.rand(1000, 4000),           
        ];
    }
}
