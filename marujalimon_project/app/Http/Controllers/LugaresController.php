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
            $lugares = Lugar::orderBy('updated_at', 'desc')->get();
            $coordinadores = Coordinador::all();
            return view('lugares.index', ['lugares' => $lugares, 'coordinadores' => $coordinadores]);
        } else {
            $coordinador = Auth::user()->coordinador;

            $lugaresAll = Lugar::orderBy('updated_at', 'desc')->get();

            if ($coordinador === null || $coordinador->lugares->isEmpty()) {

                return view('lugares.index', ['lugares' => null, 'lugaresAll' => $lugaresAll]);
            }

            $lugares = $coordinador->lugares;

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


            if ($fechaAsociacion == null) {

                $fechaAsociacion = $coordinador->created_at;

            }



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


    public function mostrarLugar($lugarId)
    {
        // Busca el lugar en la base de datos
        $lugar = Lugar::find($lugarId);

        // Si el lugar no existe, devuelve un error 404
        if (!$lugar) {
            return response()->json(['error' => 'Lugar no encontrado'], 404);
        }

        // Devuelve la vista del lugar, pasando el lugar como dato
        return view('lugares.mostrar', ['lugar' => $lugar]);
    }




    public function store(Request $request)
    {


        ValidacionUtils::validarLugar($request);

        $lugar = new Lugar();
        $lugar->LUG_nombre = $request->input('LUG_nombre');
        $lugar->LUG_direccion = $request->input('LUG_direccion');
        $lugar->LUG_localidad = $request->input('LUG_localidad');
        $lugar->LUG_provincia = $request->input('LUG_provincia');
        $lugar->LUG_delegacion = $request->input('LUG_delegacion');
        $lugar->LUG_cp = $request->input('LUG_cp');
        $lugar->LUG_url_maps = $request->input('LUG_url_maps');
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
        $datos = ValidacionUtils::validarLugar($request);

        // Actualizar los datos del lugar
        $lugar->update($datos);

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

            $coordinadores = $user->coordinador;



            $coordinadorId = $coordinadores->COO_id;

        } elseif ($user->is_admin) {
            $coordinadorId = $request->input('COO_id');
        }

        $lugarId = $user->is_coordinador ? $request->input('LUG_COO_id') : $request->input('LUG_id');

        // Verificar si el coordinador ya está asociado al lugar
        $lugar = Lugar::find($lugarId);

        if ($lugar->coordinadores()->where('COO_id', $coordinadorId)->exists()) {



            $coordinador = Coordinador::find($coordinadorId);

            if(!count($coordinador)>1){
                $message = 'El coordinador ' . $coordinador->first()->COO_name . ' ya ha sido asignado al lugar: ' . $lugar->LUG_nombre;

            }
            else  $message = 'Los coordinadores seleccionados ya han sido asignados al lugar.';




            Log::info($message);
            $success = false;
        } else {
            $coordinadores = Coordinador::find($coordinadorId);



            $now = now();
            $lugar->coordinadores()->attach($coordinadores, ['created_at' => $now, 'updated_at' => $now]);

            $listaVoluntarios = [];

            $tareas = $lugar->tareas;
            if (!$tareas->isEmpty()) {

                foreach ($tareas as $tarea) {

                    $horas = $tarea->horas;

                    if (!$horas->isEmpty()) {

                        foreach ($horas as $hora) {
                            $voluntarioID = $hora->voluntario->VOL_id;
                            $voluntario = $hora->voluntario;


                            if (!in_array($voluntarioID, $listaVoluntarios)) {
                                $listaVoluntarios[] = $voluntario->VOL_id;
                            }

                        }

                    }


                }
                if (count($listaVoluntarios) > 0) {



                    foreach ($coordinadores as $c) {


                        $c->voluntarios()->attach($listaVoluntarios);

                    }
                }

            }

            $message = 'Coordinador asignado correctamente al lugar.';
            $success = true;
        }

        // Redireccionar con el mensaje apropiado
        if ($user->is_admin) {
            $lugares = Lugar::all();
            $coordinadores = Coordinador::all();

            return response()->json(['success' => $success, 'message' => $message, 'redirect' => route('lugares.index', ['lugares' => $lugares, 'coordinadores' => $coordinadores])]);

        } elseif ($user->is_coordinador) {



            $coordinadores = $user->coordinador;
            $lugares = $coordinadores->lugares;
            $lugaresAll = Lugar::all();





            return response()->json(['success' => $success, 'message' => $message, 'redirect' => route('lugares.index', ['lugares' => $lugares, 'lugaresAll' => $lugaresAll])]);
        }
    }


}



