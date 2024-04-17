<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;
    protected $table = 'tareas';
    protected $primaryKey = 'TAR_id';

    public function lugar(){
        return $this->belongsTo(Lugar::class, 'TAR_lugar_id');
    }
    public function voluntarios()
{
    return $this->belongsToMany(Voluntario::class, 'tarea_voluntario', 'TAR_VOL_tarea_id', 'TAR_VOL_voluntario_id');
}

}
