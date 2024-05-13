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


      protected $fillable = [
        'TAR_nombre',
        'TAR_descripcion',
        'TAR_lugar_id',
    ];

    public function lugar()
    {
        return $this->belongsTo(Lugar::class, 'TAR_lugar_id');
    }

    public function horas()
    {
        return $this->hasMany(Horas::class, 'HOR_tarea_id');
    }
    public function horasTotalesTareaAnioActual()
    {
        // Obtener el primer y último día del año actual
        $primerDiaAnio = Carbon::now()->startOfYear();
        $ultimoDiaAnio = Carbon::now()->endOfYear();

        // Sumar las horas de las tareas del año actual
        $totalHorasAnio = $this->horas()
            ->whereBetween('HOR_fecha_inicio', [$primerDiaAnio, $ultimoDiaAnio])
            ->sum('HOR_horas');

        return $totalHorasAnio;
    }
    public function horasTotalesTareaMes()
    {
        // Obtener el primer y último día del mes actual
        $primerDiaMes = Carbon::now()->startOfMonth();
        $ultimoDiaMes = Carbon::now()->endOfMonth();

        // Sumar las horas de las tareas del mes actual
        $totalHorasMes = $this->horas()
            ->whereBetween('HOR_fecha_inicio', [$primerDiaMes, $ultimoDiaMes])
            ->sum('HOR_horas');

        return $totalHorasMes;

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
