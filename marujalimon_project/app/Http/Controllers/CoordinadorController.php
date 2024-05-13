<?php

namespace App\Http\Controllers;

use App\Http\Utils\FormFieldsGenerator;
use App\Http\Utils\ValidacionUtils;
use App\Models\Coordinador;
use App\Models\Delegacion;
use App\Models\ImagenPerfil;
use App\Models\Tarea;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CoordinadorController extends Controller
{





    public function index()
    {


        $coordinadores = Coordinador::orderBy('created_at', 'desc')->paginate(32);

        $tareas = Tarea::all();

        return view('coordinadores.index', ['coordinadores' => $coordinadores, 'tareas' => $tareas]);
    }


    public function show(Coordinador $coordinadore)
    {





        return view('coordinadores.show', ['coordinador' => $coordinadore]);


    }

    public function create()
    {

        $fields = FormFieldsGenerator::generateCoordinadorFields();



        $delegaciones = Delegacion::all();

        return view('coordinadores.create', [
            'delegaciones' => $delegaciones,
            'fields' => $fields,

        ]);
    }

    // En tu controlador API
public function api()
{
    $coordinadores = Coordinador::all(); // Asegúrate de tener el modelo correcto y los datos necesarios
    return response()->json($coordinadores);
}



public function getImagenPerfil($id)
{
    // Buscar el coordinador por COO_id
    $coordinador = Coordinador::with('imagenPerfil')->where('COO_id', $id)->first();

    // Verificar si el coordinador existe y tiene imagen de perfil
    if ($coordinador && $coordinador->imagenPerfil) {
        return response()->json([
            'success' => true,
            'imagenPerfil' => $coordinador->imagenPerfil
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Coordinador no encontrado o sin imagen de perfil.'
        ], 404);
    }
}






    public function store(Request $request)
    {

        ValidacionUtils::validarCoordinador($request);

        // Crear y guardar el coordinador
        $coordinador = new Coordinador();
        $coordinador->COO_nombre = $request->input('COO_nombre');
        $coordinador->COO_apellidos = $request->input('COO_apellidos');
        $coordinador->COO_dni = $request->input('COO_dni');
        $coordinador->COO_fecha_nac = $request->input('COO_fecha_nac');
        $coordinador->COO_domicilio = $request->input('COO_domicilio');
        $coordinador->COO_cp = $request->input('COO_cp');
        $coordinador->COO_localidad = $request->input('COO_localidad');
        $coordinador->COO_provincia = $request->input('COO_provincia');
        $coordinador->COO_tel = $request->input('COO_tel');
        $coordinador->COO_mail = $request->input('COO_mail');
        $coordinador->COO_trabajo_actual = $request->input('COO_trabajo_actual');
        $coordinador->COO_fecha_inicio = $request->input('COO_fecha_inicio');
        $coordinador->COO_preferencia = $request->input('COO_preferencia');
        $coordinador->COO_carnet = $request->has('COO_carnet');
        $coordinador->COO_seguro = $request->has('COO_seguro');
        $coordinador->COO_curso = $request->has('COO_curso');
        $coordinador->COO_autoriza_datos = $request->has('COO_autoriza_datos');
        $coordinador->COO_autoriza_imagen = $request->has('COO_autoriza_imagen');
        $coordinador->COO_sexo = $request->input('COO_sexo');
        $coordinador->COO_dias_semana_dispo = implode(',', $request->input('COO_dias_semana_dispo'));


        $user = User::create([
            'name' => $coordinador->COO_nombre,
            'email' => $coordinador->COO_mail,
            'password' => Hash::make($request->password),
            'is_coordinador' => true,
            'is_admin' => false,
            'is_voluntario' => false,
        ]);

        $coordinador->user_id = $user->id;
        $coordinador->save();



        $user->coordinador()->save($coordinador);

        event(new Registered($user));


        // Asignar la delegación si se proporciona
        if ($request->has('delegacion_id')) {
            $coordinador->delegaciones()->attach($request->input('delegacion_id'));
        }

        // Guardar la imagen de perfil si se proporciona
        if ($request->hasFile('imagen_perfil')) {
            $imagen = $request->file('imagen_perfil');
            $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
            $rutaImagen = $imagen->storeAs('public/img/imagenes_perfil', $nombreImagen);

            // Crear y guardar el registro de la imagen asociado al coordinador
            $imagenPerfil = new ImagenPerfil();
            $imagenPerfil->IMG_coordinador_id = $coordinador->COO_id;
            $imagenPerfil->IMG_path = str_replace('public/', '/storage/', $rutaImagen); // Ajustar la ruta para ser accesible desde la web
            $imagenPerfil->save();
        }

        return redirect()->route('coordinadores.index')->with('success', 'Coordinador creado exitosamente.');

    }

    public function edit(Coordinador $coordinadore)
    {

        $fields = FormFieldsGenerator::generateCoordinadorFields();

        $delegaciones = Delegacion::all();

        return view('coordinadores.edit', [
            'coordinador' => $coordinadore,
            'delegaciones' => $delegaciones,
            'fields' => $fields,
        ]);
    }



    public function update(Request $request, Coordinador $coordinadore)
    {


        // Validar los datos del formulario
        $validatedData = ValidacionUtils::validarCoordinadorUpdate($request, $coordinadore);
        // Procesar la actualización del coordinador





        $coordinadore->update($validatedData);


        if ($request->hasFile('imagen_perfil')) {
            // Obtiene la imagen actual asociada al voluntario
            $imagenPerfilActual = $coordinadore->imagenPerfil;

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
                $imagenPerfil->IMG_coordinador_id = $coordinadore->COO_id;
                $imagenPerfil->IMG_path = str_replace('public/', '/storage/', $rutaImagen); // Ajustar la ruta para ser accesible desde la web
                $imagenPerfil->save();
            }



        }


        // Redirigir a la vista correspondiente con un mensaje de éxito
        return redirect()->route('coordinadores.show', ['coordinadore' => $coordinadore])
            ->with('success', '¡El coordinador ha sido actualizado exitosamente!');





    }





    public function destroy(Coordinador $coordinadore)
    {
        // Eliminar el voluntario
        $coordinadore->delete();


        return redirect()->route('coordinadores.index')->with('success', 'Voluntario eliminado correctamente');


    }


}
