<?php

namespace Database\Factories;

use App\Models\Lugar;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tarea>
 */
class TareaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'TAR_nombre' => fake()->word(),
            'TAR_descripcion' => fake()->sentence(7),
            'TAR_lugar_id' => Lugar::inRandomOrder()->first()->LUG_id,
            'created_at' => fake()->dateTimeBetween('-4 year', 'now'),
        ];
    }
}
