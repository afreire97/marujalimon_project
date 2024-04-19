<?php

namespace App\Models;

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

    public function imagenPerfil(){
        return $this->hasOne(ImagenPerfil::class, 'IMG_voluntario_id');
    }




}
