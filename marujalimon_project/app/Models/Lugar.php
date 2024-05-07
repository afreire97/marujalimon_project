<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lugar extends Model
{
    use HasFactory;
    protected $table = 'lugares';
    protected $primaryKey = 'LUG_id';

    protected $fillable = [
        'LUG_nombre',
        'LUG_direccion',
        'LUG_url_maps',

    ];


    protected function tareas(){
        return $this->hasMany(Tarea::class, 'TAR_lugar_id');
    }
    public function coordinadores(){
        return $this->belongsToMany(Coordinador::class, 'coordinador_lugar', 'COO_LUG_lugar_id', 'COO_LUG_coordinador_id');
    }

    public function imagen(){
        return $this->hasOne(ImagenLugar::class, 'IMG_lugar_id');
    }







}
