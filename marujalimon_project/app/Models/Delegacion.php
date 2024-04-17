<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delegacion extends Model
{
    use HasFactory;
    protected $table = 'delegaciones';
    protected $primaryKey = 'DEL_id';
    public function voluntarios(){
        return $this->belongsToMany(Voluntario::class,'delegacion_voluntario', 'DEL_VOL_delegacion_id', 'DEL_VOL_voluntario_id');
    }
    public function provincia(){
        return $this->belongsTo(Provincia::class, 'DEL_provincia_id');
    }
    public function coordinadores()
    {
        return $this->belongsToMany(Coordinador::class, 'coordinador_delegacion', 'COO_DEL_delegacion_id', 'COO_DEL_coordinador_id');
    }
}
