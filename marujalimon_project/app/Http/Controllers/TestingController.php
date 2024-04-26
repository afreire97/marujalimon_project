<?php

namespace App\Http\Controllers;

use App\Models\Lugar;
use App\Models\Tarea;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestingController extends Controller
{
    public function index(){


        $lugares=Lugar::all();

        return view('testing.calendar', ['lugares' => $lugares]);
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
