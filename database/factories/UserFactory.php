<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Rol;
use App\Models\User;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nombres' => fake()->word(),
            'apellidos' => fake()->word(),
            'email' => fake()->safeEmail(),
            'password' => fake()->password(),
            'estrato' => fake()->randomDigitNotNull(),
            'rol_id' => Rol::factory(),
        ];
    }
}
