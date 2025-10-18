<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Regionale;

class RegionaleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Regionale::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'regional' => fake()->word(),
            'latitud' => fake()->randomFloat(6, 0, 999.999999),
            'longitud' => fake()->randomFloat(6, 0, 999.999999),
        ];
    }
}
