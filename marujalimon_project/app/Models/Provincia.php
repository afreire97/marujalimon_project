<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    use HasFactory;
    protected $table = 'provincias';
    protected $primaryKey = 'PRO_id';

    public function delegaciones(){
        return $this->hasMany(Delegacion::class, 'DEL_provincia_id');
    }

}
