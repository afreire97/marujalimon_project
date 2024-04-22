<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Horas extends Model
{
    use HasFactory;
    protected $table = 'horas_voluntariado';
    protected $primaryKey = 'HOR_id';
    protected $fillable = [
        'HOR_voluntario_id',
        'HOR_horas',
        'HOR_fecha_inicio',
        'HOR_tarea_id',
    ];


    public function voluntario()
    {
        return $this->belongsTo(Voluntario::class, 'HOR_voluntario_id');
    }

    public function tarea()
    {
        return $this->belongsTo(Tarea::class, 'TAR_id');
    }


    public static function calcularTotalHorasPorAno($ano)
    {
        // Obtener todas las horas del año especificado
        $horasDelAno = self::whereYear('HOR_fecha_inicio', $ano)->get();

        // Inicializar el array para almacenar los totales de horas por mes
        $totalHorasPorMes = [];

        // Iterar sobre cada mes del año
        foreach (range(1, 12) as $mes) {
            $nombreMes = self::nombreMes($mes);
            $horasMes = $horasDelAno
                ->whereBetween('HOR_fecha_inicio', [
                    Carbon::createFromDate($ano, $mes, 1)->startOfMonth(),
                    Carbon::createFromDate($ano, $mes, 1)->endOfMonth()
                ])
                ->sum('HOR_horas');

            // Almacenar el total de horas por mes en el array asociativo
            $totalHorasPorMes[$nombreMes] = $horasMes;
        }

        return $totalHorasPorMes;
    }

    // Método para obtener el nombre del mes en español a partir de su número
    public static function nombreMes($numeroMes)
    {
        $meses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        ];

        return $meses[$numeroMes];
    }
}
