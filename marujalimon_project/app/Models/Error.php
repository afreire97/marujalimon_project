<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Error extends Model
{
    use HasFactory;
    protected $table = 'errores';
    protected $primaryKey = 'ERR_id';

    public function voluntarios(){
        return $this->belongsTo(Voluntario::class,'ERR_voluntario_id');
    }
}
