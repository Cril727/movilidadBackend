<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Bicicleta;
use App\Models\Prestamo;
use App\Models\User;

class PrestamoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Prestamo::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'fecha_inicio' => fake()->dateTime(),
            'tarifa_recorrido' => fake()->randomFloat(2, 0, 99999999.99),
            'user_id' => User::factory(),
            'bicicleta_id' => Bicicleta::factory(),
        ];
    }
}
