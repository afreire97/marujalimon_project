<?php

namespace App\Http\Controllers;

use App\Models\Coordinador;
use Illuminate\Http\Request;

class CoordinadorController extends Controller
{





    public function index(){


        $coordinadores = Coordinador::orderBy('COO_nombre', 'asc')->paginate(15);

        return view('coordinadores.index', ['coordinadores' => $coordinadores]);
    }

public function cargarVistaGraficos(){




    return view('test_grafico');
}


}
