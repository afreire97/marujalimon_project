<?php

namespace App\Http\Controllers;

use App\Http\Utils\ValidacionUtils;
use App\Models\Coordinador;
use App\Models\ImagenLugar;
use Illuminate\Http\Request;
use App\Models\Lugar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LugaresController extends Controller
{
    // Muestra una lista de todos los lugares
    public function index()
    {



        if (Auth::user()->is_admin) {
            $lugares = Lugar::all();
            $coordinadores = Coordinador::all();
            return view('lugares.index', ['lugares' => $lugares,'coordinadores' => $coordinadores]);
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


    public function create()
    {




        return view('lugares.create');



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
    
        $coordinadorId = Auth::user()->is_coordinador ? Auth::user()->coordinador->COO_id : $request->input('COO_id');
        $lugarId = Auth::user()->is_coordinador ? $request->input('LUG_COO_id'): $request->input('LUG_id');
        Log::info($coordinadorId . $lugarId);
    
        $coordinador = Coordinador::where('COO_id', $coordinadorId)->first();
        $lugar = Lugar::where('LUG_id', $lugarId)->first();
    
        $lugar->coordinadores()->attach($coordinador);


        // $coordinador->lugares()->attach($lugar->);
    
        $message = 'Coordinador asignado correctamente al lugar.';
    
        if (Auth::user()->is_admin) {
            $lugares = Lugar::all();
            $coordinadores = Coordinador::all();
            return redirect()->route('lugares.index', ['lugares' => $lugares, 'coordinadores' => $coordinadores])->with('success', $message);
        } else {
            $coordinador = Auth::user()->coordinador;
            $lugares = $coordinador->lugares;
            $lugaresAll = Lugar::all();
            return redirect()->route('lugares.index', ['lugares' => $lugares, 'lugaresAll' => $lugaresAll])->with('success', $message);
        }
    }
    

}
