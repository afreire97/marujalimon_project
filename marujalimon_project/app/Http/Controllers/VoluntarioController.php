<?php

namespace App\Http\Controllers;

use App\Http\Utils\FormFieldsGenerator;
use App\Http\Utils\ValidacionUtils;
use App\Models\Coordinador;
use App\Models\Delegacion;
use App\Models\Horas;
use App\Models\ImagenPerfil;

use App\Models\Lugar;
use App\Models\Tarea;
use App\Models\User;
use App\Models\Voluntario;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class VoluntarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        // Obtenemos al usuario autenticado actualmente
        $user = Auth::user();

        // Verificamos si el usuario es administrador
        if ($user->is_admin) {
            // Si es administrador, obtenemos todos los voluntarios con paginación
            $voluntarios = Voluntario::orderBy('created_at', 'desc');
            $voluntarios_all = Voluntario::all();
        } else {
            // Verificamos si el usuario está asociado a un coordinador
            if ($user->is_coordinador && $user->coordinador) { // Verificar si $user->coordinador no es null
                // Si está asociado a un coordinador, obtenemos todos los voluntarios asociados a ese coordinador con paginación
                $voluntarios = $user->coordinador->voluntarios()->orderBy('created_at', 'desc')->paginate(10000000);
                $voluntarios_all = $user->coordinador->voluntarios()->get();
            } else {
                // Manejar el caso en el que el usuario no está asociado a ningún coordinador
                // Aquí puedes devolver una lista vacía o un mensaje de error según sea necesario
                $voluntarios = collect(); // Lista vacía
                $voluntarios_all = collect();
            }
        }

        // Obtener todas las tareas disponibles
        $tareas = Tarea::all();
        $lugares = Lugar::all();

        // Retornamos la vista con los voluntarios y las tareas obtenidas
        return view('voluntarios.index', ['voluntarios' => $voluntarios, 'tareas' => $tareas, 'lugares' => $lugares, 'voluntarios_all' => $voluntarios_all]);
    }







    /**
     * Display the specified resource.
     */
    public function show(Voluntario $voluntario)
    {


        // $observaciones = $voluntario->observaciones;
        // $errores = $voluntario->errores;



        return view('voluntarios.show', ['voluntario' => $voluntario]);
    }

    // public function obtenerCoordinador(Voluntario $voluntario)
    // {
    //     $coordinador = $voluntario->coordinadores;
    //     return response()->json($coordinador);
    // }

    // public function obtenerDelegaciones(Voluntario $voluntario)
    // {
    //     $delegaciones = $voluntario->delegaciones;
    //     return response()->json($delegaciones);
    // }

    // public function obtenerObservaciones(Voluntario $voluntario)
    // {
    //     $observaciones = $voluntario->observaciones;
    //     return response()->json($observaciones);
    // }
    // public function obtenerErrores(Voluntario $voluntario)
    // {
    //     $errores = $voluntario->errores;
    //     return response()->json($errores);
    // }
    // public function renderizarVistaHoras(Voluntario $voluntario)
    // {

    //     return view("voluntarios.formulario_horas", ["voluntario" => $voluntario]);
    // }

    public function calcularHoras(Request $request, Voluntario $voluntario)
    {




        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        $totalHoras = $voluntario->calcularHorasEntreFechas($fechaInicio, $fechaFin);

        return response()->json(['totalHoras' => $totalHoras]);
    }



    public function mostrarHorasPorMes(Request $request, Voluntario $voluntario)
    {



        Log::info("Entramos en el controlador");
        // Obtener el año del formulario
        $ano = $request->input('ano');

        // Calcular las horas por mes para el voluntario y el año especificado
        $horasPorMes = $voluntario->calcularHorasPorMes($ano);

        // Calcular la media de horas por mes para todos los voluntarios
        $mediaHorasPorMes = Horas::mediaHorasPorMes();

        // Devolver los resultados en formato JSON
        return new JsonResponse([
            'horasPorMes' => $horasPorMes,
            'mediaHorasPorMes' => $mediaHorasPorMes,
        ]);
    }


    public function api()
    {

        $user = Auth::user();
        $voluntarios = Voluntario::all();

        if($user->is_coordinador){
            $voluntarios = $user->coordinador->voluntarios;

        }


        return response()->json($voluntarios);
    }






    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $coordinadores = Coordinador::all();
        $fields = FormFieldsGenerator::generateVoluntarioFields();


        return view(('voluntarios.create'), ['coordinadores' => $coordinadores, 'fields' => $fields]);
    }

    /**
     * Store a newly created resource in storage.
     */



    public function store(Request $request)
    {
        ValidacionUtils::validarVoluntario($request);

        // Crear y guardar el voluntario
        $voluntario = new Voluntario();
        $voluntario->VOL_nombre = $request->input('VOL_nombre');
        $voluntario->VOL_apellidos = $request->input('VOL_apellidos');
        $voluntario->VOL_dni = $request->input('VOL_dni');
        $voluntario->VOL_fecha_nac = $request->input('VOL_fecha_nac');
        $voluntario->VOL_domicilio = $request->input('VOL_domicilio');
        $voluntario->VOL_cp = $request->input('VOL_cp');
        $voluntario->VOL_localidad = $request->input('VOL_localidad');
        $voluntario->VOL_provincia = $request->input('VOL_provincia');
        $voluntario->VOL_tel = $request->input('VOL_tel');
        $voluntario->VOL_mail = $request->input('VOL_mail');
        $voluntario->VOL_trabajo_actual = $request->input('VOL_trabajo_actual');
        $voluntario->VOL_fecha_inicio = $request->input('VOL_fecha_inicio');
        $voluntario->VOL_preferencia = $request->input('VOL_preferencia');
        $voluntario->VOL_carnet = $request->has('VOL_carnet');
        $voluntario->VOL_seguro = $request->has('VOL_seguro');
        $voluntario->VOL_curso = $request->has('VOL_curso');
        $voluntario->VOL_autoriza_datos = $request->has('VOL_autoriza_datos');
        $voluntario->VOL_autoriza_imagen = $request->has('VOL_autoriza_imagen');
        $voluntario->VOL_sexo = $request->input('VOL_sexo');
        $voluntario->VOL_dias_semana_dispo = implode(',', $request->input('VOL_dias_semana_dispo'));





        // Guardar la relación con el usuario
        $user = User::create([
            'name' => $voluntario->VOL_nombre,
            'email' => $voluntario->VOL_mail,
            'password' => Hash::make($request->password),
            'is_coordinador' => false,
            'is_admin' => false,
            'is_voluntario' => true,
        ]);
        $voluntario->user_id = $user->id;
        $voluntario->save();



        if ($request->has('COO_id')) {

            Log::info('Esta es la id del coordinador: ' . $request->input('COO_id'));
            $voluntario->coordinadores()->attach($request->input('COO_id'));

            Log::info('Se supone que esto son los coordinadores:' . $voluntario->coordinadores);
        }

        // Guardar la imagen de perfil si se proporciona
        if ($request->hasFile('imagen_perfil')) {
            $imagen = $request->file('imagen_perfil');
            $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
            $rutaImagen = $imagen->storeAs('public/img/imagenes_perfil', $nombreImagen);

            // Crear y guardar el registro de la imagen asociado al voluntario
            $imagenPerfil = new ImagenPerfil();
            $imagenPerfil->IMG_voluntario_id = $voluntario->VOL_id;
            $imagenPerfil->IMG_path = str_replace('public/', '/storage/', $rutaImagen); // Ajustar la ruta para ser accesible desde la web
            $imagenPerfil->save();
        }

        // Guardar el voluntario

        event(new Registered($user));

        return redirect()->route('voluntarios.index')->with('success', 'Voluntario creado exitosamente.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Voluntario $voluntario)
    {

        $fields = FormFieldsGenerator::generateVoluntarioFields();

        $coordinadores = Coordinador::all();



        return view(
            'voluntarios.edit',
            [
                'voluntario' => $voluntario,
                'coordinadores' => $coordinadores,
                'fields' => $fields,
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
        $datos = ValidacionUtils::validarVoluntarioUpdate($request, $voluntario);


        $voluntario->update($datos);



        if ($request->has('COO_id')) {
            $coordinadorId = $request->input('COO_id');

            // Verificar si el coordinador ya está asociado al voluntario
            if (!$voluntario->coordinadores()->where('COO_VOL_coordinador_id', $coordinadorId)->exists()) {
                // Si no está asociado, entonces asociarlo
                $voluntario->coordinadores()->attach($coordinadorId);
                // Opcional: puedes agregar un mensaje de éxito o realizar otras acciones aquí
            } else {

        return redirect()->back()->with('error', 'El coordinador ya está asociado al voluntario.');
            }
        }



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
        return redirect()->route('voluntarios.show', $voluntario)
            ->with('success', '¡Los datos del voluntario se actualizaron correctamente!');
    }




    public function getImagenPerfil($id)
    {
        // Buscar el voluntario por VOL_id
        $voluntario = Voluntario::with('imagenPerfil')->where('VOL_id', $id)->first();

        // Verificar si el voluntario existe y tiene imagen de perfil
        if ($voluntario && $voluntario->imagenPerfil) {
            return response()->json([
                'success' => true,
                'imagenPerfil' => $voluntario->imagenPerfil
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Voluntario no encontrado o sin imagen de perfil.'
            ], 404);
        }
    }
    public function destroy(Voluntario $voluntario)
    {
        // Eliminar el voluntario


        $authorizedUser = Auth::user();
        $user = $voluntario->user;
        $voluntario->delete();
        $user->delete();


        if ($authorizedUser->is_voluntario) {
            return redirect()->route('login')->with('success', 'Voluntario eliminado correctamente');
        }


        return redirect()->route('voluntarios.index')->with('success', 'Voluntario eliminado correctamente');
    }
}
