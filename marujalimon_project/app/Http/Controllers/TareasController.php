<?php

namespace App\Http\Controllers;

use App\Models\Lugar;
use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TareasController extends Controller
{




    public function totalTareasPorMes(Request $request)
    {
        $year = $request->input('year');

        // Obtener el total de tareas realizadas cada mes para el año seleccionado
        $totalTareasPorMes = Tarea::calcularTotalTareasPorAno($year);

        return response()->json(['totalTareasPorMes' => $totalTareasPorMes]);
    }








    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {




        // Crear una nueva tarea con los datos proporcionados
        $tarea = new Tarea();
        $tarea->TAR_nombre = $request->TAR_nombre;
        $tarea->TAR_descripcion = $request->TAR_descripcion;
        $tarea->TAR_lugar_id = $request->TAR_lugar_id;
        $tarea->save();




        $lugar = Lugar::where('LUG_id', $tarea->TAR_lugar_id)->first();


        return redirect()->route('lugares.show', ['lugar' => $lugar]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Tarea $tarea)
    {
        $horas = $tarea->horas;

        return view('tareas.show', ['tarea' => $tarea, 'horas' => $horas]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarea $tarea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'nueva_tarea' => 'required|string',
            'nueva_descripcion' => 'required|string',
        ]);



        $tarea = Tarea::where('TAR_id', $request->tarea_id);

        // Actualizar los datos de la tarea
        $tarea->update([
            'TAR_nombre' => $request->nueva_tarea,
            'TAR_descripcion' => $request->nueva_descripcion,
        ]);

        // Redireccionar o devolver una respuesta JSON según lo necesites
        return response()->json(['message' => 'Tarea actualizada correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarea $tarea)
    {

            // Eliminar la tarea

            $lugar = $tarea->lugar;
            $tarea->delete();

            // Redireccionar o devolver una respuesta JSON según lo necesites
            return redirect()->route('lugares.show', ['lugar' => $lugar]);

    }


    public function buscar(Request $request)
    {
        $query = $request->input('query');
        $tareas = Tarea::where('TAR_nombre', 'LIKE', "%{$query}%")->get(['TAR_id as id', 'TAR_nombre as nombre']);
        return response()->json($tareas);
    }
    
    
}


