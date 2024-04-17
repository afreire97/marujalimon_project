<?php

namespace Database\Factories;

use App\Models\Voluntario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Observacion>
 */
class ObservacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'OBS_contenido' => Str::limit(fake()->sentence(15), 255),
            'OBS_voluntario_id' => Voluntario::inRandomOrder()->first()->VOL_id,

        ];
    }
}
