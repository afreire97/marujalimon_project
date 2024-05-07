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
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Crear un usuario coordinador
        $aaron = User::factory()->create([
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

       $voluntarioUser=  User::factory()->create([
            'name' => 'Jose',
            'email' => 'jose@mail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // Usa bcrypt para encriptar la contraseña
            'is_voluntario' => true, // Establecer el usuario como coordinador
            // Puedes agregar más atributos según sea necesario
        ]);

        $voluntario = Voluntario::factory()->create();
        $voluntario->user()->associate($voluntarioUser);
        $voluntario->save();


        Provincia::factory(10)->create();

        $coordinadores = Coordinador::factory(15)->create();

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

        // Asigna una imagen a cada lugar
        $lugares->each(function ($lugar) {
            App\Models\ImagenLugar::factory()->create(['IMG_lugar_id' => $lugar->LUG_id]);
        });
        $coordinadoresDisponibles = Coordinador::all();

        foreach ($lugares as $lugar) {
            // Selecciona uno o varios coordinadores aleatorios
            $coordinadores = $coordinadoresDisponibles->random(rand(1, 3)); // Cambia el rango según tus necesidades

            // Asigna los coordinadores al lugar utilizando el método de relación
            $now = now(); // Obtiene la fecha y hora actual
$lugar->coordinadores()->attach($coordinadores, ['created_at' => $now, 'updated_at' => $now]);

        }
        // Crear tareas y asignarlas a lugares
        Tarea::factory(100)->create()->each(function ($tarea) use ($lugares) {
            $lugar = $lugares->random();
            $tarea->lugar()->associate($lugar)->save();

            // Obtener un número aleatorio de horas para la tarea (entre 1 y 12)
            $numHoras = rand(3, 8);

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
