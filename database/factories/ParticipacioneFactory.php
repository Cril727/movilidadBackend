<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Evento;
use App\Models\Participacione;
use App\Models\User;

class ParticipacioneFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Participacione::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'evento_id' => Evento::factory(),
            'user_id' => User::factory(),
        ];
    }
}
