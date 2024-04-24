<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordinador extends Model
{
    use HasFactory;
    protected $table = 'coordinadores';
    protected $primaryKey = 'COO_id';

    protected $fillable = [
        'COO_nombre',
        'COO_apellidos',
        'COO_dni',
        'COO_fecha_nac',
        'COO_domicilio',
        'COO_cp',
        'COO_tel1',
        'COO_sexo',
        'COO_mail',
        'user_id',
    ];

    public function delegaciones()
    {
        return $this->belongsToMany(Delegacion::class, 'coordinador_delegacion', 'COO_DEL_delegacion_id', 'COO_DEL_coordinador_id');
    }
    public function voluntarios(){
        return $this->belongsToMany(Voluntario::class, 'coordinador_voluntario', 'COO_VOL_coordinador_id', 'COO_VOL_voluntario_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
