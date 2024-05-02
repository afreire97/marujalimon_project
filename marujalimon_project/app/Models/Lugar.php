<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lugar extends Model
{
    use HasFactory;
    protected $table = 'lugares';
    protected $primaryKey = 'LUG_id';

    protected function tareas(){
        return $this->hasMany(Tarea::class, 'TAR_lugar_id');
    }
    public function coordinadores(){
        return $this->belongsToMany(Coordinador::class, 'coordinador_lugar', 'COO_LUG_lugar_id', 'COO_LUG_coordinador_id');
    }
}
