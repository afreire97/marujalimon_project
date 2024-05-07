<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lugar>
 */
class LugarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'LUG_nombre' => fake()->company(),
            'LUG_direccion' => fake()->address(),
            'LUG_url_maps' => 'https://maps.app.goo.gl/V197oh1SYAWMyZLn6',
        ];
    }
}
