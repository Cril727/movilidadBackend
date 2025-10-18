<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Bicicleta;
use App\Models\Regionale;

class BicicletaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bicicleta::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'marca' => fake()->word(),
            'color' => fake()->word(),
            'estado' => fake()->randomElement(["Disponible","Prestada","Mantenimiento"]),
            'precioAlquiler' => fake()->word(),
            'regional_id' => Regionale::factory(),
        ];
    }
}
