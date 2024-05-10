<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voluntario extends Model
{
    use HasFactory;
    protected $table = 'voluntarios';
    protected $primaryKey = 'VOL_id';

    protected $fillable = [
        'VOL_nombre',
        'VOL_apellidos',
        'VOL_dni',
        'VOL_fecha_nac',
        'VOL_domicilio',
        'VOL_cp',
        'VOL_tel1',
        'VOL_sexo',
        'VOL_mail',
        'user_id',
    ];


    public function delegaciones(){
        return $this->belongsToMany(Delegacion::class,'delegacion_voluntario' ,'DEL_VOL_voluntario_id', 'DEL_VOL_delegacion_id');
    }
   public function coordinadores(){
        return $this->belongsToMany(Coordinador::class, 'coordinador_voluntario', 'COO_VOL_voluntario_id', 'COO_VOL_coordinador_id');
    }
 public function observaciones(){
        return $this->hasMany(Observacion::class, 'OBS_voluntario_id');
    }

    public function errores(){
        return $this->hasMany(Error::class,'ERR_voluntario_id');
    }

    public function horas(){
        return $this->hasMany(Horas::class, 'HOR_voluntario_id');
    }
    public function calcularHorasEntreFechas($fechaInicio, $fechaFin) {
        return $this->horas()
                    ->whereBetween('HOR_fecha_inicio', [$fechaInicio, $fechaFin])
                    ->sum('HOR_horas');
    }

    public function calcularHorasPorMes($ano)
    {
        // Obtener todas las horas del año especificado para el voluntario
        $horasDelAno = $this->horas()
            ->whereYear('HOR_fecha_inicio', $ano)
            ->get();

        // Inicializar el array para almacenar los totales de horas por mes
        $horasPorMes = [];

        // Calcular el total de horas por mes
        foreach (range(1, 12) as $mes) {
            $horasPorMes[$this->nombreMes($mes)] = $horasDelAno
                ->whereBetween('HOR_fecha_inicio', [
                    Carbon::createFromDate($ano, $mes, 1)->startOfMonth(),
                    Carbon::createFromDate($ano, $mes, 1)->endOfMonth()
                ])
                ->sum('HOR_horas');
        }

        // Retornar el array con los totales de horas por mes
        return $horasPorMes;
    }

    // Método para obtener el nombre del mes a partir de su número
    public function nombreMes($numeroMes)
    {
        return \DateTime::createFromFormat('!m', $numeroMes)->format('F');
    }


    // En tu modelo Voluntario
public function imagenPerfil() {
    return $this->hasOne('App\Models\ImagenPerfil', 'IMG_voluntario_id');
}



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }




}
