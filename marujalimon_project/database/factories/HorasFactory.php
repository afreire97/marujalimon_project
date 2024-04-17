<?php

namespace Database\Factories;

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
        return [
            'HOR_voluntario_id' =>  Voluntario::inRandomOrder()->first()->VOL_id, // Asume que tienes una fábrica para Voluntario
            'HOR_horas' => fake()->randomNumber(1, 12), // Genera un número decimal entre 0.5 y 8
            'HOR_fecha_inicio' => fake()->dateTimeBetween('-1 year', 'now'), // Fecha aleatoria en el último año
        ];
    }
}
