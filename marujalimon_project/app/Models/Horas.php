<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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


    public function voluntario(){
        return $this->belongsTo(Voluntario::class, 'HOR_voluntario_id');
    }

    public function tarea()
    {
        return $this->belongsTo(Tarea::class, 'TAR_id');
    }
}
