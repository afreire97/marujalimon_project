<?php

namespace App\Http\Controllers;

use App\Http\Utils\ValidacionUtils;
use App\Models\ImagenLugar;
use Illuminate\Http\Request;
use App\Models\Lugar;
use Illuminate\Support\Facades\Auth;

class LugaresController extends Controller
{
    // Muestra una lista de todos los lugares
    public function index()
    {



        if (Auth::user()->is_admin) {
            $lugares = Lugar::all();
        } else {
            $coordinador = Auth::user()->coordinador;
            $lugares = $coordinador->lugares;
        }


        return view('lugares.index', ['lugares' => $lugares]);
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


}
