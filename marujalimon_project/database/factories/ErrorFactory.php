<?php

namespace Database\Factories;

use App\Models\Voluntario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Error>
 */
class ErrorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ERR_descripcion' => fake()->sentence(6),
            'ERR_voluntario_id' => Voluntario::inRandomOrder()->first()->VOL_id,
        ];
    }
}
