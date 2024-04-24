<?php

namespace App\Http\Controllers;

use App\Models\Coordinador;
use App\Models\Tarea;
use Illuminate\Http\Request;

class CoordinadorController extends Controller
{





    public function index(){


        $coordinadores = Coordinador::orderBy('COO_nombre', 'asc')->paginate(15);

        $tareas = Tarea::all();

        return view('coordinadores.index', ['coordinadores' => $coordinadores, 'tareas' => $tareas]);
    }


    public function show(Coordinador $coordinador){





        return  view('coordinadores.show', ['coordinador' => $coordinador]);


    }







public function cargarVistaGraficos(){




    return view('test_grafico');
}


}
