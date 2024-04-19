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

    public function horas(){


        return $this->hasMany(Horas::class, 'TAR_hora_id');



    }


}
