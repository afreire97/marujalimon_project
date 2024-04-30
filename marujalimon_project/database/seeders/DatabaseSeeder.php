<?php

use App\Models\Coordinador;
use App\Models\Delegacion;
use App\Models\Error;
use App\Models\Horas;
use App\Models\Lugar;
use App\Models\Observacion;
use App\Models\Provincia;
use App\Models\Tarea;
use App\Models\User;
use App\Models\Voluntario;
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
            'password' => bcrypt('password'), // Usa bcrypt para encriptar la contraseña
            'is_coordinador' => true, // Establecer el usuario como coordinador
            // Puedes agregar más atributos según sea necesario
        ]);

        User::factory()->create([
            'name' => 'PEPE',
            'email' => 'pepe@mail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // Usa bcrypt para encriptar la contraseña
            'is_admin' => true, // Establecer el usuario como coordinador
            // Puedes agregar más atributos según sea necesario
        ]);






        Provincia::factory(10)->create();

        $coordinadores = Coordinador::factory(50)->create();

        // Crear delegaciones y asignarles un coordinador
        $delegaciones = Delegacion::factory(4)->create();
        $delegaciones->each(function ($delegacion) use ($coordinadores) {
            $coordinador = $coordinadores->random();
            $delegacion->coordinadores()->attach($coordinador);
        });

        // Crear voluntarios
        $voluntarios = Voluntario::factory(200)->create();

        // Asignar voluntarios a delegaciones (y por ende a coordinadores)
        $voluntarios->each(function ($voluntario) use ($delegaciones) {
            $delegacion = $delegaciones->random();
            $voluntario->delegaciones()->attach($delegacion);
            $voluntario->coordinadores()->attach($delegacion->coordinadores()->inRandomOrder()->first());
        });

        // Crear observaciones
        Observacion::factory(50)->create();

        // Crear errores
        Error::factory(50)->create();

        // Crear lugares
        $lugares = Lugar::factory(10)->create();

        // Crear tareas y asignarlas a lugares
        Tarea::factory(100)->create()->each(function ($tarea) use ($lugares) {
            $lugar = $lugares->random();
            $tarea->lugar()->associate($lugar)->save();

            // Obtener un número aleatorio de horas para la tarea (entre 1 y 12)
            $numHoras = rand(0, 3);

            // Crear y asociar las horas a la tarea
            for ($i = 0; $i < $numHoras; $i++) {
                Horas::factory()->create([
                    'HOR_tarea_id' => $tarea->TAR_id,
                    'HOR_fecha_inicio' => $tarea->created_at,
                ]);
            }
        });
    }
}
