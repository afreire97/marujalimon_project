<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lugar;
use Illuminate\Support\Facades\Auth;

class LugaresController extends Controller
{
    // Muestra una lista de todos los lugares
    public function index()
    {



        if(Auth::user()->is_admin){
            $lugares = Lugar::all();
        }else{
            $coordinador = Auth::user()->coordinador;
            $lugares = $coordinador->lugares;
        }


        return view('lugares.index', ['lugares' => $lugares]);
    }


    // Muestra un lugar específico
    public function show(Lugar $lugar)
    {
        $tareasLugar = $lugar->tareas;



        return view('tareas.index', [ 'tareas' => $tareasLugar, 'lugar' => $lugar]);
    }

}
