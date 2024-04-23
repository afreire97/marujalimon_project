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
        $usuario = User::factory()->create([
            'name' => 'aaron',
            'email' => 'aaron@mail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // Usa bcrypt para encriptar la contraseña
            'is_coordinador' => true, // Establecer el usuario como coordinador
            // Puedes agregar más atributos según sea necesario
        ]);

        $coordinador = Coordinador::factory()->create([
            'COO_nombre' => fake()->name(),
            'COO_dni' => fake()->randomNumber(8),
            'user_id' => $usuario->id,
        ]);

        // Crear provincias, coordinadores y delegaciones
        Provincia::factory(6)->create();
        $delegaciones = Delegacion::factory(4)->create();

        // Asignar coordinadores a delegaciones
        $delegaciones->each(function ($delegacion) use ($coordinador) {
            $delegacion->coordinadores()->attach($coordinador);
        });

        // Crear voluntarios
        $voluntarios = Voluntario::factory(50)->create();

        // Asignar voluntarios a delegaciones y coordinadores
        $voluntarios->each(function ($voluntario) use ($delegaciones) {
            $delegacion = $delegaciones->random();
            $coordinador = $delegacion->coordinadores->first();
            $voluntario->delegaciones()->attach($delegacion);
            $voluntario->coordinadores()->attach($coordinador);
        });

        // Asignar algunos voluntarios a más de una delegación
        $voluntarios->random(5)->each(function ($voluntario) use ($delegaciones) {
            $otrasDelegaciones = $delegaciones->where('id', '!=', $voluntario->delegaciones->first()->id);
            foreach ($otrasDelegaciones as $delegacion) {
                $coordinador = $delegacion->coordinadores->first();
                $voluntario->delegaciones()->attach($delegacion);
                $voluntario->coordinadores()->attach($coordinador);
            }
        });

        $voluntarioCuatro = Voluntario::find(4);
        $coordinadores = Coordinador::limit(3)->get();

        foreach ($coordinadores as $coordinador) {
            $voluntarioCuatro->coordinadores()->attach($coordinador);
        }

        // Crear observaciones
        Observacion::factory(50)->create();

        // Crear errores
        Error::factory(27)->create();

        // Crear lugares
        $lugares = Lugar::factory(10)->create();

        // Crear tareas y asignarlas a lugares
        Tarea::factory(150)->create()->each(function ($tarea) use ($lugares) {
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
