<?php

namespace App\Http\Controllers;

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


        $coordinadores = Coordinador::orderBy('COO_nombre', 'asc')->paginate(8);

        $tareas = Tarea::all();

        return view('coordinadores.index', ['coordinadores' => $coordinadores, 'tareas' => $tareas]);
    }


    public function show(Coordinador $coordinador)
    {





        return view('coordinadores.show', ['coordinador' => $coordinador]);


    }

    public function create()
    {

        $fields = [
            'COO_nombre' => 'Nombre',
            'COO_apellidos' => 'Apellidos',
            'COO_dni' => 'DNI',
            'COO_fecha_nac' => 'Fecha de nacimiento',
            'COO_domicilio' => 'Dirección',
            'COO_cp' => 'Código Postal',
            'COO_tel1' => 'Teléfono',
            'COO_sexo' => 'Género',
            'COO_mail' => 'Correo Electrónico',
        ];

        $selectFields = [
            'COO_sexo' => ['Masculino', 'Femenino', 'Otro'],
        ];

        $delegaciones = Delegacion::all();

        return view('coordinadores.create', [
            'delegaciones' => $delegaciones,
            'fields' => $fields,
            'selectFields' => $selectFields
        ]);
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
        $coordinador->COO_tel1 = $request->input('COO_tel1');
        $coordinador->COO_sexo = $request->input('COO_sexo');
        $coordinador->COO_mail = $request->input('COO_mail');

       $user = User::create([
            'name' => $coordinador->COO_nombre,
            'email' =>  $coordinador->COO_mail,
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

    public function edit(Coordinador $coordinador)
    {
        $fields = [
            'COO_nombre' => 'Nombre',
            'COO_apellidos' => 'Apellidos',
            'COO_dni' => 'DNI',
            'COO_fecha_nac' => 'Fecha de nacimiento',
            'COO_domicilio' => 'Dirección',
            'COO_cp' => 'Código Postal',
            'COO_tel1' => 'Teléfono',
            'COO_sexo' => 'Género',
            'COO_mail' => 'Correo Electrónico',
        ];

        $selectFields = [
            'COO_sexo' => ['Masculino', 'Femenino', 'Otro'],
        ];

        $delegaciones = Delegacion::all();

        return view('coordinadores.edit', [
            'coordinador' => $coordinador,
            'delegaciones' => $delegaciones,
            'fields' => $fields,
            'selectFields' => $selectFields
        ]);
    }



    public function update(Request $request, Coordinador $coordinador)
    {


        // Validar los datos del formulario
        $validatedData = $this->validateCoordinadorData($request, $coordinador);

        // Procesar la actualización del coordinador


        $coordinador->update($validatedData);
        if ($request->hasFile('imagen_perfil')) {
            // Obtiene la imagen actual asociada al voluntario
            $imagenPerfilActual = $coordinador->imagenPerfil;

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
                $imagenPerfil->IMG_coordinador_id = $coordinador->COO_id;
                $imagenPerfil->IMG_path = str_replace('public/', '/storage/', $rutaImagen); // Ajustar la ruta para ser accesible desde la web
                $imagenPerfil->save();
            }






            // Redirigir a la vista correspondiente con un mensaje de éxito
            return redirect()->route('coordinador.show', ['coordinador' => $coordinador])
                ->with('success', '¡El coordinador ha sido actualizado exitosamente!');
        }
    }




    public function destroy(Coordinador $coordinador)
    {
        // Eliminar el voluntario
        $coordinador->delete();


        return redirect()->route('coordinadores.index')->with('success', 'Voluntario eliminado correctamente');


    }

    protected function validateCoordinadorData(Request $request, Coordinador $coordinador)
    {
        return $request->validate([
            'COO_nombre' => 'required|string|max:255',
            'COO_apellidos' => 'nullable|string|max:255',
            'COO_dni' => [
                'required',
                'string',
                'max:255',
                Rule::unique('coordinadores', 'COO_dni')->ignore($coordinador->COO_id, 'COO_id'),
            ],
            'COO_fecha_nac' => 'nullable|date',
            'COO_domicilio' => 'nullable|string|max:255',
            'COO_cp' => 'nullable|string|max:255',
            'COO_tel1' => 'nullable|string|max:255',
            'COO_sexo' => 'nullable|in:Masculino,Femenino,Otro',
            'COO_mail' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('coordinadores', 'COO_mail')->ignore($coordinador->COO_mail, 'COO_mail'),
            ],
            'delegacion_id' => 'nullable|exists:delegaciones,DEL_id',
            'imagen_perfil' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validación de la imagen de perfil


        ], [
            'COO_nombre.required' => 'El nombre del coordinador es obligatorio.',
            'COO_dni.required' => 'El DNI del coordinador es obligatorio.',
            'COO_dni.unique' => 'El DNI ya está en uso.',
            'COO_mail.required' => 'El correo electrónico del coordinador es obligatorio.',
            'COO_mail.email' => 'El correo electrónico debe ser válido.',
            'COO_mail.unique' => 'El correo electrónico ya está en uso.',
            'delegacion_id.exists' => 'La delegación seleccionada no es válida.',
            'imagen_perfil.image' => 'El archivo debe ser una imagen.',
            'imagen_perfil.mimes' => 'El archivo debe ser de tipo: jpeg, png, jpg o gif.',
            'imagen_perfil.max' => 'El tamaño máximo del archivo es de 2048 kilobytes (2MB).',
        ]);
    }

}
