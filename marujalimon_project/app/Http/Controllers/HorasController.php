<?php

namespace App\Http\Controllers;

use App\Models\Horas;
use App\Models\Voluntario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

Log::info('Mensaje informativo');
Log::error('Mensaje de error');

class HorasController extends Controller
{
    //



    public function mostrarHorasPorMes(Request $request)
    {
        // Obtener el año del formulario
        $year = $request->input('year');

        // Calcular el total de horas para cada mes del año especificado
        $totalHorasPorMes = Horas::calcularTotalHorasPorAno($year);

        // Devolver los resultados en formato JSON
        return response()->json([
            'totalHorasPorMes' => $totalHorasPorMes,
        ]);
    }

    public function mostrarTareasPorMes(Request $request)
    {

        $year = $request->input('year');




    }


    public function añadirHoras(Request $request)
    {


        // Obtener los datos del formulario
        $voluntariosIds = json_decode($request->input('voluntariosSeleccionados')); // Convertir la cadena JSON en un array PHP



        $horas = $request->input('horas');
        $tareaId = $request->input('tarea_id');

        // Agregar horas a los voluntarios
        $resultados = Horas::agregarHorasVoluntarios($voluntariosIds, $horas, $tareaId);

        // Verificar el resultado y manejar los mensajes de éxito o error
        if (in_array(false, $resultados, true)) {
            // Si hubo algún error, establecer mensaje de error
            $request->session()->flash('error', 'No se pudieron añadir las horas para todos los voluntarios.');
        } else {
            // Si las horas se agregaron correctamente para todos los voluntarios, establecer mensaje de éxito
            $request->session()->flash('success', 'Horas añadidas correctamente para todos los voluntarios.');
        }

        return redirect()->route('voluntarios.index');
    }


}


