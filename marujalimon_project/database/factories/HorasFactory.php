<?php

namespace Database\Factories;

use App\Models\Tarea;
use App\Models\Voluntario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Horas>
 */
class HorasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Obtener un voluntario aleatorio
        $voluntario = Voluntario::inRandomOrder()->first();

        // Obtener una tarea aleatoria

        return [
            'HOR_voluntario_id' => $voluntario->VOL_id,
            'HOR_horas' => fake()->numberBetween(1, 4), // Genera un número entre 1 y 12

        ];
    }
}
