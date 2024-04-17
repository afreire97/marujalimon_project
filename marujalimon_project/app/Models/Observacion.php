<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observacion extends Model
{
    use HasFactory;
    protected $table = 'observaciones';
    protected $primaryKey = 'OBS_id';
    public function voluntarios(){
        return $this->belongsTo(Voluntario::class, 'OBS_observacion_id');
    }
}
