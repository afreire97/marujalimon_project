<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenLugar extends Model
{
    use HasFactory;


    protected $fillable = [
        'IMG_lugar_id',
        'IMG_path',
    ];

    protected $table = 'imagen_lugares';
    protected $primaryKey = 'IMG_LUG_id';



    public function lugar()
    {
        return $this->belongsTo(Lugar::class, 'IMG_lugar_id');
    }


    public function imagenes()
    {
        return $this->hasMany(ImagenLugar::class, 'IMG_lugar_id', 'LUG_id');
    }

}
