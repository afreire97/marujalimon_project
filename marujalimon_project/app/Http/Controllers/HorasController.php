<?php

namespace App\Http\Controllers;

use App\Models\Horas;
use App\Models\Voluntario;
use Illuminate\Http\Request;

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



    public function añadirHoras(Request $request)
    {
        // Validar los datos del formulario (puedes agregar reglas de validación según sea necesario)

        $request->validate([
            'voluntarioId' => 'required|exists:voluntarios,VOL_id', // Validar que el ID del voluntario exista en la tabla 'voluntarios'
            'horas' => 'required|integer', // Ejemplo de regla de validación para las horas
            'tarea_id' => 'required|exists:tareas,TAR_id', // Validar que la tarea seleccionada exista en la tabla 'tareas'
        ]);

        // Obtener los datos del formulario

        $voluntarioId = $request->input('voluntarioId');
        $horas = $request->input('horas');
        $tareaId = $request->input('tarea_id');

        // Crear una nueva hora con los datos del formulario
        $hora = new Horas();
        $hora->HOR_voluntario_id = $voluntarioId;
        $hora->HOR_horas = $horas;
        $hora->HOR_fecha_inicio = now();
        $hora->HOR_tarea_id = $tareaId;

        // Guardar la hora en la base de datos
        $hora->save();

        // Devolver un mensaje de éxito
        return response()->json([
           'message' => 'Hora agregada exitosamente',
        ]);
        $horas = $request->input('horas');
        $tareaId = $request->input('tarea_id');

        // Agregar horas al voluntario
        $resultado = Horas::agregarHorasVoluntario($voluntarioId, $horas, $tareaId);

        // Verificar el resultado y manejar los mensajes de éxito o error
        if ($resultado) {
            // Si las horas se agregaron correctamente, establecer mensaje de éxito
            $request->session()->flash('success', 'Horas añadidas correctamente.');
        } else {
            // Si hubo algún error, establecer mensaje de error
            $request->session()->flash('error', 'No se pudieron añadir las horas.');
        }

        return redirect()->route('voluntarios.show', $voluntarioId);
    }


}


