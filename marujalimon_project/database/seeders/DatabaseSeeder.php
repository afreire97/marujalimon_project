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
        $aaron = User::factory()->create([
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
        $voluntarioUser = User::factory()->create([
            'name' => 'Jose',
            'email' => 'jose@mail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'is_voluntario' => true,
        ]);

        // Obtener voluntarios y coordinadores
        $voluntarios = Voluntario::all();
        $coordinadores = Coordinador::all();

        // Preparar datos para inserción masiva de voluntarios
        $voluntariosData = $voluntarios->map(function ($voluntario) {
            return [
                'name' => $voluntario->VOL_nombre ?: 'Unknown',
                'email' => $voluntario->VOL_mail ?: generateEmail($voluntario->VOL_nombre, $voluntario->VOL_apellidos),
                'password' => bcrypt('password'),
                'is_voluntario' => true,
            ];
        })->toArray();

        // Preparar datos para inserción masiva de coordinadores
        $coordinadoresData = $coordinadores->map(function ($coordinador) {
            return [
                'name' => $coordinador->COO_nombre ?: 'Unknown',
                'email' => $coordinador->COO_mail ?: generateEmail($coordinador->COO_nombre, $coordinador->COO_apellidos),
                'password' => bcrypt('password'),
                'is_coordinador' => true,
            ];
        })->toArray();

        // Insertar usuarios voluntarios de forma masiva
        $voluntariosIds = [];
        foreach ($voluntariosData as $userData) {
            $voluntariosIds[] = User::insertGetId($userData);
        }

        // Asociar los usuarios voluntarios con los modelos Voluntario correspondientes
        foreach ($voluntariosIds as $key => $userId) {
            $voluntario = Voluntario::where('VOL_nombre', $voluntariosData[$key]['name'])->first();
            if ($voluntario) {
                $voluntario->user_id = $userId;
                $voluntario->save();
            }
        }

        // Insertar usuarios coordinadores de forma masiva
        $coordinadoresIds = [];
        foreach ($coordinadoresData as $userData) {
            $coordinadoresIds[] = User::insertGetId($userData);
        }

        // Asociar los usuarios coordinadores con los modelos Coordinador correspondientes
        foreach ($coordinadoresIds as $key => $userId) {
            $coordinador = Coordinador::where('COO_nombre', $coordinadoresData[$key]['name'])->first();
            if ($coordinador) {
                $coordinador->user_id = $userId;
                $coordinador->save();
            }
        }
    }
}

function generateEmail($nombre, $apellidos)
        {
            // Limpiar el nombre para eliminar caracteres especiales y convertir a minúsculas
            $nombre_limpio = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $nombre));

            // Tomar las primeras cinco letras del apellido si existe
            $apellido = $apellidos ? substr(preg_replace('/[^a-zA-Z0-9]/', '', $apellidos), 0, 5) : '';

            // Crear un correo electrónico único para el usuario
            return $nombre_limpio . $apellido . '@mail.com';
        }
