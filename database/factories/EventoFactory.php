<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Evento;
use App\Models\Regionale;

class EventoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Evento::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->word(),
            'fecha' => fake()->date(),
            'estado' => fake()->randomElement(["Disponible","Ejecucion","Finalizado"]),
            'regional_id' => Regionale::factory(),
        ];
    }
}
