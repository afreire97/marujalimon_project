<?php

namespace App\Http\Controllers;

use App\Models\Coordinador;
use App\Models\Delegacion;
use App\Models\Horas;
use App\Models\ImagenPerfil;
use App\Models\Observacion;
use App\Models\Error;
use App\Models\Tarea;
use App\Models\Voluntario;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
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
            $voluntarios = Voluntario::orderBy('created_at', 'desc')->paginate();
            $voluntarios_all = Voluntario::all();
        } else {
            // Verificamos si el usuario está asociado a un coordinador
            if ($user->is_coordinador && $user->coordinador) { // Verificar si $user->coordinador no es null
                // Si está asociado a un coordinador, obtenemos todos los voluntarios asociados a ese coordinador con paginación
                $voluntarios = $user->coordinador->voluntarios()->orderBy('created_at', 'desc')->paginate();
                $voluntarios_all = $user->coordinador->voluntarios()->get();
            } else {
                // Manejar el caso en el que el usuario no está asociado a ningún coordinador
                // Aquí puedes devolver una lista vacía o un mensaje de error según sea necesario
                $voluntarios = collect(); // Lista vacía

            }
        }

        // Obtener todas las tareas disponibles
        $tareas = Tarea::all();


        // Retornamos la vista con los voluntarios y las tareas obtenidas
        return view('voluntarios.listar_voluntarios_card', ['voluntarios' => $voluntarios, 'tareas' => $tareas, 'voluntarios_all' => $voluntarios_all]);
    }
    /**
     * Display the specified resource.
     */
    public function show(Voluntario $voluntario)
    {


        // $observaciones = $voluntario->observaciones;
        // $errores = $voluntario->errores;



        return view('voluntarios.informacion_voluntario', ['voluntario' => $voluntario]);
    }

    public function obtenerCoordinador(Voluntario $voluntario)
    {
        $coordinador = $voluntario->coordinadores;
        return response()->json($coordinador);
    }

    public function obtenerDelegaciones(Voluntario $voluntario)
    {
        $delegaciones = $voluntario->delegaciones;
        return response()->json($delegaciones);
    }

    public function obtenerObservaciones(Voluntario $voluntario)
    {
        $observaciones = $voluntario->observaciones;
        return response()->json($observaciones);
    }
    public function obtenerErrores(Voluntario $voluntario)
    {
        $errores = $voluntario->errores;
        return response()->json($errores);
    }
    public function renderizarVistaHoras(Voluntario $voluntario)
    {

        return view("voluntarios.formulario_horas", ["voluntario" => $voluntario]);
    }

    public function calcularHoras(Request $request, Voluntario $voluntario)
    {




        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        $totalHoras = $voluntario->calcularHorasEntreFechas($fechaInicio, $fechaFin);

        return view('voluntarios.informacion_voluntario', ['voluntario' => $voluntario, 'totalHoras' => $totalHoras]);



    }



    public function mostrarHorasPorMes(Request $request, Voluntario $voluntario)
    {
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







    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $coordinadores = Coordinador::all();
        $delegaciones = Delegacion::all();

        return view(('voluntarios.crear_voluntario_form'), ['coordinadores' => $coordinadores, 'delegaciones' => $delegaciones]);
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
        $voluntario->VOL_tel1 = $request->input('VOL_tel1');
        $voluntario->VOL_sexo = $request->input('VOL_sexo');
        $voluntario->VOL_mail = $request->input('VOL_mail');
        $voluntario->save();

        // Asignar la delegación y el coordinador
        $voluntario->delegaciones()->attach($request->input('DEL_id'));
        $voluntario->coordinadores()->attach($request->input('COO_id'));

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

        return redirect()->route('voluntarios.create')->with('success', 'Voluntario creado exitosamente.');
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
            'voluntarios.edit_form',
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
        return redirect()->route('voluntarios.show', $voluntario)
            ->with('success', '¡Los datos del voluntario se actualizaron correctamente!');
    }





    public function destroy(Voluntario $voluntario)
    {
        // Eliminar el voluntario
        $voluntario->delete();


        return redirect()->route('voluntarios.index')->with('success', 'Voluntario eliminado correctamente');


    }


    public function getInfo(Voluntario $voluntario)
    {


        return view('voluntarios.info_voluntario_view', ['voluntario' => $voluntario]);
    }


}
class ValidacionUtils
{
    public static function validarVoluntario(Request $request)
    {
        return $request->validate([
            'VOL_nombre' => 'required|string',
            'VOL_apellidos' => 'required|string',
            'VOL_dni' => 'required|string|unique:voluntarios,VOL_dni',
            'VOL_fecha_nac' => 'required|date',
            'VOL_domicilio' => 'required|string',
            'VOL_cp' => 'required|string',
            'VOL_tel1' => 'required|string',
            'VOL_sexo' => 'required|in:Masculino,Femenino,Otro',
            'VOL_mail' => 'required|email|unique:voluntarios,VOL_mail',
            'DEL_id' => 'required|exists:delegaciones,DEL_id',
            'COO_id' => 'required|exists:coordinadores,COO_id',
            'imagen_perfil' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validación de la imagen de perfil
        ], [
            'VOL_nombre.required' => 'El campo Nombre es obligatorio.',
            'VOL_apellidos.required' => 'El campo Apellidos es obligatorio.',
            'VOL_dni.required' => 'El campo DNI es obligatorio.',
            'VOL_fecha_nac.required' => 'El campo Fecha de Nacimiento es obligatorio.',
            'VOL_domicilio.required' => 'El campo Domicilio es obligatorio.',
            'VOL_cp.required' => 'El campo Código Postal es obligatorio.',
            'VOL_tel1.required' => 'El campo Teléfono es obligatorio.',
            'VOL_sexo.required' => 'El campo Sexo es obligatorio.',
            'VOL_mail.required' => 'El campo Correo Electrónico es obligatorio.',
            'DEL_id.required' => 'Debes seleccionar una delegación.',
            'COO_id.required' => 'Debes seleccionar un coordinador.',
            'VOL_dni.unique' => 'El DNI ingresado ya está en uso.',
            'VOL_mail.unique' => 'El correo electrónico ingresado ya está en uso.',
            'VOL_mail.email' => 'El formato del correo electrónico no es válido.',
            'imagen_perfil.image' => 'El archivo debe ser una imagen.',
            'imagen_perfil.mimes' => 'El archivo debe ser de tipo: jpeg, png, jpg o gif.',
            'imagen_perfil.max' => 'El tamaño máximo del archivo es de 2048 kilobytes (2MB).',
        ]);
    }
    public static function validarDatosFormularioUpdate(Request $request)
    {
        $data = $request->all();
        $booleanFields = [
            'VOL_tiene_usuario',
            'VOL_autoriza_datos',
            'VOL_dispo_dot',
            'VOL_dispo_cubierta',
            'VOL_autoriza_uso_imagen',
            'VOL_autoriza_uso_imagen_cubierto',
            'VOL_for_for_inicial',
            'VOL_for_mayores',
            'VOL_for_menores',
            'VOL_for_discapacidad',
            'VOL_for_otras',
        ];

        foreach ($booleanFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = $data[$field] == '1' ? true : false;
            }
        }

        // Reglas de validación para los campos del formulario
        $rules = [
            'VOL_nombre' => 'required|string|max:255',
            'VOL_apellidos' => 'required|string|max:255',
            'VOL_dni' => [
                'required',
                'string',
                Rule::unique('voluntarios', 'VOL_dni')->ignore($request->voluntario->VOL_id, 'VOL_id'),
            ],
            'VOL_fecha_nac' => 'required|date',
            'VOL_domicilio' => 'required|string|max:255',
            'VOL_cp' => 'required|string|max:5',
            'VOL_tel1' => 'required|string|max:9',
            'VOL_sexo' => 'required|string|in:Masculino,Femenino,Otro',
            'VOL_mail' => 'required|string|email|max:255',
            'VOL_fecha_baja' => 'nullable|date',
            'VOL_col_pref' => 'nullable|string|max:255',
            'VOL_carnet' => 'nullable|string|max:255',
            'VOL_seguro' => 'nullable|string|max:255',
            'VOL_seguro_exento' => 'nullable|string|max:255',
            'VOL_cdns' => 'nullable|string|max:255',
            'VOL_cdns_pdf' => 'nullable|string|max:255',
            'VOL_curso' => 'nullable|string|max:255',
            'VOL_demandas' => 'nullable|string|max:255',
            'VOL_lugar_voluntariado' => 'nullable|string|max:255',
            'VOL_dias_semana_dispo.*' => 'nullable|string|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
            'imagen_perfil' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validación de la imagen de perfil
            'imagen_perfil.image' => 'El archivo debe ser una imagen.',
            'imagen_perfil.mimes' => 'El archivo debe ser de tipo: jpeg, png, jpg o gif.',
            'imagen_perfil.max' => 'El tamaño máximo del archivo es de 2048 kilobytes (2MB).',
        ];

        $messages = [
            'VOL_nombre.required' => 'El campo :attribute es obligatorio.',
            'VOL_apellidos.required' => 'El campo :attribute es obligatorio.',
            'VOL_dni.required' => 'El campo :attribute es obligatorio.',
            'VOL_fecha_nac.required' => 'El campo :attribute es obligatorio.',
            'VOL_domicilio.required' => 'El campo :attribute es obligatorio.',
            'VOL_cp.required' => 'El campo :attribute es obligatorio.',
            'VOL_tel1.required' => 'El campo :attribute es obligatorio.',
            'VOL_sexo.required' => 'El campo :attribute es obligatorio.',
            'VOL_mail.required' => 'El campo :attribute es obligatorio.',
            'VOL_fecha_baja.required' => 'El campo :attribute es obligatorio.',
            'VOL_col_pref.required' => 'El campo :attribute es obligatorio.',
            'VOL_dni.unique' => 'El :attribute ya está en uso.',
            'VOL_mail.email' => 'Por favor, introduce una dirección de correo electrónico válida en el campo :attribute.',
            'VOL_cp.regex' => 'El campo :attribute debe contener 5 dígitos numéricos.',
            'VOL_tel1.regex' => 'El campo :attribute debe contener 9 dígitos numéricos.',
            'imagen_perfil' => [
                'image' => 'El archivo debe ser una imagen.',
                'mimes' => 'El archivo debe ser de tipo: jpeg, png, jpg o gif.',
                'max' => 'El tamaño máximo del archivo es de 2048 kilobytes (2MB).',
            ],
            // mensajes de validación personalizados...
        ];

        return $request->validate($rules, $messages);
    }


}

class FormFieldsGenerator
{
    public static function generateVoluntarioFields()
    {
        return [
            'VOL_nombre' => 'Nombre',
            'VOL_apellidos' => 'Apellidos',
            'VOL_dni' => 'DNI',
            'VOL_fecha_nac' => 'Fecha de Nacimiento',
            'VOL_domicilio' => 'Domicilio',
            'VOL_cp' => 'Código Postal',
            'VOL_tel1' => 'Teléfono',
            'VOL_sexo' => 'Sexo',
            'VOL_mail' => 'Correo Electrónico',
            'VOL_fecha_baja' => 'Fecha de Baja',
            'VOL_col_pref' => 'Color Preferido',
            'VOL_carnet' => 'Carnet',
            'VOL_seguro' => 'Seguro',
            'VOL_seguro_exento' => 'Seguro Exento',
            'VOL_cdns' => 'CDNS',
            'VOL_cdns_pdf' => 'CDNS PDF',
            'VOL_curso' => 'Curso',
            'VOL_demandas' => 'Demandas',
            'VOL_lugar_voluntariado' => 'Lugar de Voluntariado',
            'VOL_dispo_dot' => 'Disponibilidad DOT',
            'VOL_dispo_cubierta' => 'Disponibilidad Cubierta',
            'VOL_autoriza_uso_imagen' => 'Autoriza Uso de Imagen',
            'VOL_autoriza_uso_imagen_cubierto' => 'Autoriza Uso de Imagen Cubierto',
            'VOL_for_for_inicial' => 'For de Formación Inicial',
            'VOL_for_mayores' => 'For de Mayores',
            'VOL_for_menores' => 'For de Menores',
            'VOL_for_discapacidad' => 'For de Discapacidad',
            'VOL_for_otras' => 'For de Otras',
        ];
    }
}

