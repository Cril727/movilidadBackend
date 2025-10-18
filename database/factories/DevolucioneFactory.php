<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Bicicleta;
use App\Models\Devolucione;
use App\Models\Prestamo;
use App\Models\User;

class DevolucioneFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Devolucione::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'total_cobrado' => fake()->randomFloat(2, 0, 99999999.99),
            'adicional_cobrado' => fake()->randomFloat(2, 0, 99999999.99),
            'fecha' => fake()->dateTime(),
            'prestamo_id' => Prestamo::factory(),
            'user_id' => User::factory(),
            'bicicleta_id' => Bicicleta::factory()->create()->i,
        ];
    }
}
