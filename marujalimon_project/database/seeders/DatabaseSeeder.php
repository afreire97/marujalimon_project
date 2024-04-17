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
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {


        User::factory(1)->create();

        // Crear provincias, coordinadores y delegaciones
        Provincia::factory(6)->create();
        $coordinadores = Coordinador::factory(1)->create();
        $delegaciones = Delegacion::factory(4)->create();

        // Asignar coordinadores a delegaciones
        $delegaciones->each(function ($delegacion) use ($coordinadores) {
            $coordinador = $coordinadores->random();
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

        // Crear horas de voluntariado
        $voluntarios->each(function ($voluntario) {
            \App\Models\Horas::factory()->count(rand(1, 5))->create([
                'HOR_voluntario_id' => $voluntario->VOL_id
            ]);

        });
        $lugares = Lugar::factory(10)->create();

        // Crear tareas y asignarlas a lugares
        Tarea::factory(50)->create()->each(function ($tarea) use ($lugares) {
            $lugar = $lugares->random();
            $tarea->lugar()->associate($lugar)->save();
        });

        // Asignar tareas a voluntarios
        Tarea::all()->each(function ($tarea) use ($voluntarios) {
            $tarea->voluntarios()->attach($voluntarios->random(rand(1, 5))->pluck('VOL_id'));
        });
    }
}
