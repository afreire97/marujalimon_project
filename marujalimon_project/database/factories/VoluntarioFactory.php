<?php

namespace Database\Factories;

use App\Models\Coordinador;
use App\Models\Delegacion;
use App\Models\Localidad;
use App\Models\Provincia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Voluntario>
 */
class VoluntarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [


            'VOL_nombre' => fake()->name(),
            'VOL_apellidos' => fake()->name(),
            'VOL_dni' => fake()->numerify('#########'),
            'VOL_fecha_nac' => fake()->date(),
            'VOL_domicilio' => fake()->address(),
            'VOL_cp' => fake()->postcode(),
            'VOL_tel1' => fake()->phoneNumber(),
            'VOL_sexo' => fake()->randomElement(['Masculino', 'Femenino', 'Otro']),
            'VOL_mail' => fake()->unique()->email(),

            'VOL_dias_semana_dispo' => fake()->randomElement(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo', null]),




        ];
    }
}
