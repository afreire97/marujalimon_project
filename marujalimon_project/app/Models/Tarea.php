<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Tarea extends Model
{
    use HasFactory;
    protected $table = 'tareas';
    protected $primaryKey = 'TAR_id';

    public function lugar()
    {
        return $this->belongsTo(Lugar::class, 'TAR_lugar_id');
    }

    public function horas()
    {


        return $this->hasMany(Horas::class, 'TAR_hora_id');



    }
    public static function calcularTotalTareasPorAno($ano)
    {
        // Obtener todas las tareas del año especificado
        $tareasDelAno = self::whereYear('created_at', $ano)->get();

        // Inicializar el array para almacenar los totales de tareas por mes
        $totalTareasPorMes = [];

        // Iterar sobre cada mes del año
        foreach (range(1, 12) as $mes) {
            $nombreMes = self::nombreMes($mes);
            $tareasMes = $tareasDelAno
                ->whereBetween('created_at', [
                    Carbon::createFromDate($ano, $mes, 1)->startOfMonth(),
                    Carbon::createFromDate($ano, $mes, 1)->endOfMonth()
                ])
                ->count();

            // Almacenar el total de tareas por mes en el array asociativo
            $totalTareasPorMes[$nombreMes] = $tareasMes;
        }

        return $totalTareasPorMes;
    }

    // Función para obtener el nombre de un mes en español
    private static function nombreMes($numeroMes)
    {
        return Carbon::createFromDate(null, $numeroMes, null)->locale('es')->monthName;
    }

}
