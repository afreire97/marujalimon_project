<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenPerfil extends Model
{
    use HasFactory;
    protected $table = 'imagen_perfiles';
    protected $primaryKey = 'IMG_id';

    protected $fillable = ['IMG_path'];

    public function voluntario(){
        return $this->belongsTo(Voluntario::class, 'IMG_voluntario_id');
    }
}
