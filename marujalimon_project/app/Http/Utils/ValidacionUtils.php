<?php
namespace App\Http\Utils;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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

