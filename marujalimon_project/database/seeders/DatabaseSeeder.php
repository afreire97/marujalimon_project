<?php

use App\Models\Coordinador;
use App\Models\Voluntario;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Crear un usuario coordinador
        User::factory()->create([
            'name' => 'aaron',
            'email' => 'aaron@mail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'is_coordinador' => true,
        ]);

        // Crear un usuario administrador
        User::factory()->create([
            'name' => 'PEPE',
            'email' => 'pepe@mail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        // Crear un usuario voluntario
        User::factory()->create([
            'name' => 'Jose',
            'email' => 'jose@mail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'is_voluntario' => true,
        ]);


    }
}

