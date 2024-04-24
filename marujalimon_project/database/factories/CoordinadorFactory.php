<?php

namespace Database\Factories;

use App\Models\Delegacion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coordinador>
 */
class CoordinadorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $usuario = User::inRandomOrder()->first();

        return [
            'COO_nombre' => fake()->name(),
            'COO_dni' => fake()->randomNumber(8),
            'user_id' => $usuario->id, // Asociar el ID del usuario obtenido
            'COO_apellidos' => fake()->name(),
            'COO_fecha_nac' => fake()->date(),
            'COO_domicilio' => fake()->address(),
            'COO_cp' => fake()->postcode(),
            'COO_tel1' => fake()->phoneNumber(),
            'COO_sexo' => fake()->randomElement(['Masculino', 'Femenino', 'Otro']),
            'COO_mail' => fake()->unique()->email(),



        ];
    }
}
