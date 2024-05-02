<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lugar;

class LugaresController extends Controller
{
    // Muestra una lista de todos los lugares
    public function index()
    {
        $lugares = Lugar::all();

        return view('lugares.index', ['lugares' => $lugares]);
    }


    // Muestra un lugar específico
    public function show(Lugar $lugar)
    {
        $tareasLugar = $lugar->tareas;

        return view('tareas.index', [ 'tareas' => $tareasLugar, 'lugar' => $lugar]);
    }

}
