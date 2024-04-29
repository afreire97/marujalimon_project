<?php

namespace App\Http\Controllers;

use App\Models\Lugar;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarioController extends Controller
{
    //

    public function index(){


        $lugares=Lugar::all();

        $voluntario = Auth::user()->voluntario;
        return view('voluntario_logeado.calendario', ['lugares' => $lugares, 'voluntario' => $voluntario]);
    }

    public function obtenerTareasLugar($lugarId)
    {

        $lugar = Lugar::findOrFail($lugarId);

        // Obtener las tareas relacionadas con el lugar
        $tareas = $lugar->tareas;


        return new JsonResponse([
            'lugar' => $lugar,
            'tareas' => $tareas,
        ]);

    }
}
