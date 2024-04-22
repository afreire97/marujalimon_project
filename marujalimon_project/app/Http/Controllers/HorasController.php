<?php

namespace App\Http\Controllers;

use App\Models\Horas;
use Illuminate\Http\Request;

class HorasController extends Controller
{
    //



    public function mostrarHorasPorMes(Request $request)
    {
        // Obtener el año del formulario
        $ano = $request->input('ano');

        // Calcular el total de horas para cada mes del año especificado
        $totalHorasPorMes = Horas::calcularTotalHorasPorAno($ano);

        // Devolver los resultados en formato JSON
        return response()->json([
            'totalHorasPorMes' => $totalHorasPorMes,
        ]);
    }

}


