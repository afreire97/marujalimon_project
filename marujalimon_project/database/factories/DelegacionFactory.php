<?php

namespace Database\Factories;

use App\Models\Coordinador;
use App\Models\Provincia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Delegacion>
 */
class DelegacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'DEL_nombre' => fake()->company(),
            'DEL_localidad' => fake()->city(),
            'DEL_provincia_id' => Provincia::inRandomOrder()->first()->PRO_id,
        ];
    }
}
