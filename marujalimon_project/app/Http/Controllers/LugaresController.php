<?php

namespace App\Http\Controllers;

use App\Http\Utils\ValidacionUtils;
use App\Models\Coordinador;
use App\Models\ImagenLugar;
use Illuminate\Http\Request;
use App\Models\Lugar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LugaresController extends Controller
{
    // Muestra una lista de todos los lugares
    public function index()
    {



        if (Auth::user()->is_admin) {
            $lugares = Lugar::all();
            $coordinadores = Coordinador::all();
            return view('lugares.index', ['lugares' => $lugares, 'coordinadores' => $coordinadores]);
        } else {
            $coordinador = Auth::user()->coordinador;
            $lugares = $coordinador->lugares;
            $lugaresAll = Lugar::all();
            return view('lugares.index', ['lugares' => $lugares, 'lugaresAll' => $lugaresAll]);
        }



    }


    // Muestra un lugar específico
    public function show(Lugar $lugar)
    {
        $tareasLugar = $lugar->tareas;



        return view('tareas.index', ['tareas' => $tareasLugar, 'lugar' => $lugar]);
    }

    public function showVoluntarios(Lugar $lugar)
    {
        $tareasLugar = $lugar->tareas;
        $voluntarios = [];
        $coordinadores = $lugar->coordinadores;
        $fechasAsociacion = [];

        foreach ($coordinadores as $coordinador) {
            $fechaAsociacion = DB::table('coordinador_lugar')
                ->where('COO_LUG_coordinador_id', $coordinador->COO_id)
                ->latest('created_at')
                ->value('created_at');
            Log::info('fecha' . $fechaAsociacion);
            $fechasAsociacion[$coordinador->COO_id] = $fechaAsociacion;
        }
        foreach ($tareasLugar as $tarea) {
            foreach ($tarea->horas as $hora) {
                if (!in_array($hora->voluntario, $voluntarios)) {
                    $voluntarios[] = $hora->voluntario;

                }
            }
        }

        return view('lugares.show', [
            'lugar' => $lugar,
            'voluntarios' => $voluntarios,
            'coordinadores' => $coordinadores,

            'fechasAsociacion' => $fechasAsociacion
        ]);
    }



    public function create()
    {




        return view('lugares.create');



    }

    //     public function destroy(Lugar $lugar)
// {
//     // Eliminar el lugar
//     $lugar->delete();

    //     // Redireccionar o devolver una respuesta JSON según lo necesites
//     return redirect()->route('lugares.index');
// }

    public function destroy(Lugar $lugar)
    {
        $user = Auth::user();

        if ($user->is_coordinador) {

            $coordinador = $user->coordinador;
            // Eliminar la relación entre el coordinador y el lugar
            $coordinador->lugares()->detach($lugar->LUG_id);

            return redirect()->route('lugares.index')
                ->with('success', 'Relación entre el coordinador y el lugar eliminada correctamente.');

        } elseif ($user->is_admin) {
            $lugar->delete();
            return redirect()->route('lugares.index');

        }

    }



    public function store(Request $request)
    {


        ValidacionUtils::validarLugar($request);

        $lugar = new Lugar();
        $lugar->LUG_nombre = $request->input('LUG_nombre');
        $lugar->LUG_direccion = $request->input('LUG_direccion');
        $lugar->save();

        // Guardar la imagen del lugar si se proporciona
        if ($request->hasFile('IMG_path')) {
            $imagen = $request->file('IMG_path');
            $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
            $rutaImagen = $imagen->storeAs('public/img/imagenes_lugar', $nombreImagen);

            // Crear y guardar el registro de la imagen asociado al lugar
            $imagenLugar = new ImagenLugar();
            $imagenLugar->IMG_path = str_replace('public/', '/storage/', $rutaImagen); // Ajustar la ruta para ser accesible desde la web
            $lugar->imagen()->save($imagenLugar);
        }

        return redirect()->route('lugares.index')->with('success', 'Lugar creado exitosamente.');


    }



    public function edit(Lugar $lugar)
    {
        return view('lugares.edit', ['lugar' => $lugar]);
    }
    public function update(Request $request, Lugar $lugar)
    {
        // Validar los datos del formulario
        ValidacionUtils::validarLugar($request);

        // Actualizar los datos del lugar
        $lugar->update([
            'LUG_nombre' => $request->input('LUG_nombre'),
            'LUG_direccion' => $request->input('LUG_direccion'),
        ]);

        // Actualizar la imagen si se proporciona
        if ($request->hasFile('IMG_path')) {
            $imagen = $request->file('IMG_path');
            $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
            $rutaImagen = $imagen->storeAs('public/img/lugares', $nombreImagen);

            // Actualizar la ruta de la imagen del lugar
            $lugar->imagen->update([
                'IMG_path' => str_replace('public/', '/storage/', $rutaImagen),
            ]);
        }

        return redirect()->route('lugares.index')->with('success', 'Lugar actualizado exitosamente.');
    }



    public function asignarCoordinador(Request $request)
    {
        // Validar la solicitud si es necesario

        $user = Auth::user();
        if ($user->is_coordinador) {
            $coordinadorId = $user->coordinador->COO_id;
        } elseif ($user->is_admin) {
            $coordinadorId = $request->input('COO_id');
        }

        $lugarId = $user->is_coordinador ? $request->input('LUG_COO_id') : $request->input('LUG_id');

        // Verificar si el coordinador ya está asociado al lugar
        $lugar = Lugar::find($lugarId);
        if ($lugar->coordinadores->contains('COO_id', $coordinadorId)) {
            $message = 'El coordinador ya está asignado a este lugar.';
            $success = false;
        } else {
            $coordinador = Coordinador::find($coordinadorId);


            $now = now();
            $lugar->coordinadores()->attach($coordinador, ['created_at' => $now, 'updated_at' => $now]);



            $message = 'Coordinador asignado correctamente al lugar.';
            $success = true;
        }

        // Redireccionar con el mensaje apropiado
        if ($user->is_admin) {
            $lugares = Lugar::all();
            $coordinadores = Coordinador::all();
            return response()->json(['success' => $success, 'message' => $message, 'redirect' => route('lugares.index', ['lugares' => $lugares, 'coordinadores' => $coordinadores])]);
        } else {
            $coordinador = $user->coordinador;
            $lugares = $coordinador->lugares;
            $lugaresAll = Lugar::all();
            return response()->json(['success' => $success, 'message' => $message, 'redirect' => route('lugares.index', ['lugares' => $lugares, 'lugaresAll' => $lugaresAll])]);
        }
    }


}
