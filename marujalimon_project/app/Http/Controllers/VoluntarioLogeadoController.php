<?php

namespace App\Http\Controllers;

use App\Http\Utils\FormFieldsGenerator;
use App\Http\Utils\ValidacionUtils;
use App\Models\ImagenPerfil;
use App\Models\Voluntario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VoluntarioLogeadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = Auth::user();


        $voluntario = $user->voluntario;


        return view('voluntario_logeado.index', ['voluntario' => $voluntario]);


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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Voluntario $voluntario)
    {



        return view('voluntario_logeado.index', ['voluntario' => $voluntario]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Voluntario $voluntario)
    {

        $fields = FormFieldsGenerator::generateVoluntarioFields();
        $selectFields = [
            'VOL_sexo' => ['Masculino', 'Femenino', 'Otro'],
        ];
        $delegaciones = $voluntario->delegaciones;
        $coordinadores = $voluntario->coordinadores;

        return view(
            'voluntario_logeado.edit',
            [
                'voluntario' => $voluntario,
                'delegaciones' => $delegaciones,
                'coordinadores',
                $coordinadores,
                'fields' => $fields,
                'selectFields' => $selectFields
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Voluntario $voluntario)
    {
        // Validar los datos del formulario


        // Obtener todos los datos de la solicitud
        $datos = ValidacionUtils::validarDatosFormularioUpdate($request);


        $voluntario->update($datos);

        // Guardar la imagen de perfil si se proporciona
        if ($request->hasFile('imagen_perfil')) {
            // Obtiene la imagen actual asociada al voluntario
            $imagenPerfilActual = $voluntario->imagenPerfil;

            // Si hay una imagen actual, elimínala y luego guarda la nueva
            if ($imagenPerfilActual) {
                Storage::delete($imagenPerfilActual->IMG_path);
            }

            // Guarda la nueva imagen proporcionada
            $imagen = $request->file('imagen_perfil');
            $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
            $rutaImagen = $imagen->storeAs('public/img/imagenes_perfil', $nombreImagen);

            // Actualiza la ruta de la imagen asociada al voluntario
            if ($imagenPerfilActual) {
                $imagenPerfilActual->update(['IMG_path' => str_replace('public/', '/storage/', $rutaImagen)]);
            } else {
                // Si no hay una imagen asociada, crea una nueva
                $imagenPerfil = new ImagenPerfil();
                $imagenPerfil->IMG_voluntario_id = $voluntario->VOL_id;
                $imagenPerfil->IMG_path = str_replace('public/', '/storage/', $rutaImagen); // Ajustar la ruta para ser accesible desde la web
                $imagenPerfil->save();
            }
        }

        // Redireccionar a la vista con un mensaje de éxito
        return redirect()->route('voluntario_logeado.index', $voluntario)
            ->with('success', '¡Los datos del voluntario se actualizaron correctamente!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Voluntario $voluntario)
    {
        //
    }
}
