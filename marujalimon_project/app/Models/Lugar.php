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
}