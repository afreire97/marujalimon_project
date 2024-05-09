<?php
namespace App\Http\Utils;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ValidacionUtils
{
    public static function validarVoluntario(Request $request)
{
    return $request->validate([
        'VOL_nombre' => 'nullable|string',
        'VOL_apellidos' => 'nullable|string',
        'VOL_dni' => 'nullable|string|unique:voluntarios,VOL_dni',
        'VOL_fecha_nac' => 'nullable|date',
        'VOL_domicilio' => 'nullable|string',
        'VOL_cp' => 'nullable|string',
        'VOL_localidad' => 'nullable|string',
        'VOL_provincia' => 'nullable|string',
        'VOL_tel' => 'nullable|string',
        'VOL_mail' => 'nullable|email|unique:voluntarios,VOL_mail',
        'VOL_trabajo_actual' => 'nullable|string',
        'VOL_fecha_inicio' => 'nullable|date',
        'VOL_preferencia' => 'nullable|string',
        'VOL_carnet' => 'nullable|boolean',
        'VOL_seguro' => 'nullable|boolean',
        'VOL_curso' => 'nullable|string',
        'VOL_autoriza_datos' => 'nullable|boolean',
        'VOL_autoriza_imagen' => 'nullable|boolean',
        'VOL_sexo' => 'nullable|string|in:Mujer,Hombre,',
        'VOL_dias_semana_dispo' => 'nullable|array',
        'VOL_dias_semana_dispo.*' => 'in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
        'imagen_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación de la imagen de perfil
        'DEL_id' => 'nullable|exists:delegaciones,DEL_id', // Validación de la delegación
        'COO_id' => 'nullable|exists:coordinadores,COO_id', // Validación del coordinador
        'password' => 'required|string|min:8',
        'password2' => 'required|string|min:8|same:password',
    ], [
        'VOL_nombre.string' => 'El campo Nombre debe ser una cadena de caracteres.',
        'VOL_apellidos.string' => 'El campo Apellidos debe ser una cadena de caracteres.',
        'VOL_dni.string' => 'El campo DNI debe ser una cadena de caracteres.',
        'VOL_dni.unique' => 'El DNI ingresado ya está en uso.',
        'VOL_fecha_nac.date' => 'El campo Fecha de Nacimiento debe ser una fecha válida.',
        'VOL_domicilio.string' => 'El campo Domicilio debe ser una cadena de caracteres.',
        'VOL_cp.string' => 'El campo Código Postal debe ser una cadena de caracteres.',
        'VOL_localidad.string' => 'El campo Localidad debe ser una cadena de caracteres.',
        'VOL_provincia.string' => 'El campo Provincia debe ser una cadena de caracteres.',
        'VOL_tel.string' => 'El campo Teléfono debe ser una cadena de caracteres.',
        'VOL_mail.email' => 'El formato del correo electrónico no es válido.',
        'VOL_mail.unique' => 'El correo electrónico ingresado ya está en uso.',
        'VOL_trabajo_actual.string' => 'El campo Trabajo Actual debe ser una cadena de caracteres.',
        'VOL_fecha_inicio.date' => 'El campo Fecha de Inicio debe ser una fecha válida.',
        'VOL_preferencia.string' => 'El campo Preferencia debe ser una cadena de caracteres.',
        'VOL_carnet.boolean' => 'El campo Carnet debe ser un valor booleano.',
        'VOL_seguro.boolean' => 'El campo Seguro debe ser un valor booleano.',
        'VOL_curso.string' => 'El campo Curso debe ser una cadena de caracteres.',
        'VOL_autoriza_datos.boolean' => 'El campo Autorización de Datos debe ser un valor booleano.',
        'VOL_autoriza_imagen.boolean' => 'El campo Autorización de Imagen debe ser un valor booleano.',
        'VOL_sexo.string' => 'El campo Sexo debe ser una cadena de caracteres.',
        'VOL_sexo.in' => 'El campo Sexo debe ser Mujer, Hombre o estar vacío.',
        'VOL_dias_semana_dispo.array' => 'El campo Disponibilidad debe ser una lista de días de la semana.',
        'VOL_dias_semana_dispo.*.in' => 'El campo Disponibilidad contiene un valor inválido.',
        'imagen_perfil.image' => 'El archivo debe ser una imagen.',
        'imagen_perfil.mimes' => 'El archivo debe ser de tipo: jpeg, png, jpg o gif.',
        'imagen_perfil.max' => 'El tamaño máximo del archivo es de 2048 kilobytes (2MB).',
        'DEL_id.exists' => 'La delegación seleccionada no es válida.',
        'COO_id.exists' => 'El coordinador seleccionado no es válido.',
        'password.required' => 'El campo Contraseña es obligatorio.',
        'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        'password2.required' => 'El campo Confirmar Contraseña es obligatorio.',
        'password2.min' => 'La confirmación de la contraseña debe tener al menos 8 caracteres.',
        'password2.same' => 'La confirmación de la contraseña no coincide con la contraseña.',
    ]);
}


    public static function validarLugar(Request $request)
    {
        return $request->validate([
            'LUG_nombre' => 'required|string|max:255',
            'LUG_direccion' => 'required|string|max:255',
            'IMG_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación de la imagen si se proporciona
        ], [
            'LUG_nombre.required' => 'El campo Nombre es obligatorio.',
            'LUG_direccion.required' => 'El campo Dirección es obligatorio.',
            'IMG_path.image' => 'El archivo debe ser una imagen.',
            'IMG_path.mimes' => 'El archivo debe ser de tipo: jpeg, png, jpg o gif.',
            'IMG_path.max' => 'El tamaño máximo del archivo es de 2048 kilobytes (2MB).',
        ]);
    }
    public static function validarCoordinador(Request $request)
    {
        return $request->validate([
            'COO_nombre' => 'required|string',
            'COO_apellidos' => 'required|string',
            'COO_dni' => 'required|string|unique:coordinadores,COO_dni',
            'COO_fecha_nac' => 'required|date',
            'COO_domicilio' => 'required|string',
            'COO_cp' => 'required|string',
            'COO_tel1' => 'required|string',
            'COO_sexo' => 'required|in:Masculino,Femenino,Otro',
            'COO_mail' => 'required|email|unique:coordinadores,COO_mail',
            'imagen_perfil' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validación de la imagen de perfil
            'password' => 'required|string|min:8|confirmed',
        ], [
            'COO_nombre.required' => 'El campo Nombre es obligatorio.',
            'COO_apellidos.required' => 'El campo Apellidos es obligatorio.',
            'COO_dni.required' => 'El campo DNI es obligatorio.',
            'COO_fecha_nac.required' => 'El campo Fecha de Nacimiento es obligatorio.',
            'COO_domicilio.required' => 'El campo Domicilio es obligatorio.',
            'COO_cp.required' => 'El campo Código Postal es obligatorio.',
            'COO_tel1.required' => 'El campo Teléfono es obligatorio.',
            'COO_sexo.required' => 'El campo Sexo es obligatorio.',
            'COO_mail.required' => 'El campo Correo Electrónico es obligatorio.',
            'COO_dni.unique' => 'El DNI ingresado ya está en uso.',
            'COO_mail.unique' => 'El correo electrónico ingresado ya está en uso.',
            'COO_mail.email' => 'El formato del correo electrónico no es válido.',
            'imagen_perfil.image' => 'El archivo debe ser una imagen.',
            'imagen_perfil.mimes' => 'El archivo debe ser de tipo: jpeg, png, jpg o gif.',
            'imagen_perfil.max' => 'El tamaño máximo del archivo es de 2048 kilobytes (2MB).',
            'password.required' => 'El campo Password es obligatorio.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
        ]);
    }



    public static function validarDatosFormularioUpdate(Request $request)
    {
        return $request->validate([
            'VOL_nombre' => 'nullable|string',
            'VOL_apellidos' => 'nullable|string',
            'VOL_dni' => 'nullable|string|unique:voluntarios,VOL_dni',
            'VOL_fecha_nac' => 'nullable|date',
            'VOL_domicilio' => 'nullable|string',
            'VOL_cp' => 'nullable|string',
            'VOL_localidad' => 'nullable|string',
            'VOL_provincia' => 'nullable|string',
            'VOL_tel' => 'nullable|string',
            'VOL_mail' => 'nullable|email|unique:voluntarios,VOL_mail',
            'VOL_trabajo_actual' => 'nullable|string',
            'VOL_fecha_inicio' => 'nullable|date',
            'VOL_preferencia' => 'nullable|string',
            'VOL_carnet' => 'nullable|boolean',
            'VOL_seguro' => 'nullable|boolean',
            'VOL_curso' => 'nullable|string',
            'VOL_autoriza_datos' => 'nullable|boolean',
            'VOL_autoriza_imagen' => 'nullable|boolean',
            'VOL_sexo' => 'nullable|string|in:Mujer,Hombre,',
            'VOL_dias_semana_dispo' => 'nullable|array',
            'VOL_dias_semana_dispo.*' => 'in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
            'imagen_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación de la imagen de perfil
            'DEL_id' => 'nullable|exists:delegaciones,DEL_id', // Validación de la delegación
            'COO_id' => 'nullable|exists:coordinadores,COO_id', // Validación del coordinador

        ], [
            'VOL_nombre.string' => 'El campo Nombre debe ser una cadena de caracteres.',
            'VOL_apellidos.string' => 'El campo Apellidos debe ser una cadena de caracteres.',
            'VOL_dni.string' => 'El campo DNI debe ser una cadena de caracteres.',
            'VOL_dni.unique' => 'El DNI ingresado ya está en uso.',
            'VOL_fecha_nac.date' => 'El campo Fecha de Nacimiento debe ser una fecha válida.',
            'VOL_domicilio.string' => 'El campo Domicilio debe ser una cadena de caracteres.',
            'VOL_cp.string' => 'El campo Código Postal debe ser una cadena de caracteres.',
            'VOL_localidad.string' => 'El campo Localidad debe ser una cadena de caracteres.',
            'VOL_provincia.string' => 'El campo Provincia debe ser una cadena de caracteres.',
            'VOL_tel.string' => 'El campo Teléfono debe ser una cadena de caracteres.',
            'VOL_mail.email' => 'El formato del correo electrónico no es válido.',
            'VOL_mail.unique' => 'El correo electrónico ingresado ya está en uso.',
            'VOL_trabajo_actual.string' => 'El campo Trabajo Actual debe ser una cadena de caracteres.',
            'VOL_fecha_inicio.date' => 'El campo Fecha de Inicio debe ser una fecha válida.',
            'VOL_preferencia.string' => 'El campo Preferencia debe ser una cadena de caracteres.',
            'VOL_carnet.boolean' => 'El campo Carnet debe ser un valor booleano.',
            'VOL_seguro.boolean' => 'El campo Seguro debe ser un valor booleano.',
            'VOL_curso.string' => 'El campo Curso debe ser una cadena de caracteres.',
            'VOL_autoriza_datos.boolean' => 'El campo Autorización de Datos debe ser un valor booleano.',
            'VOL_autoriza_imagen.boolean' => 'El campo Autorización de Imagen debe ser un valor booleano.',
            'VOL_sexo.string' => 'El campo Sexo debe ser una cadena de caracteres.',
            'VOL_sexo.in' => 'El campo Sexo debe ser Mujer, Hombre o estar vacío.',
            'VOL_dias_semana_dispo.array' => 'El campo Disponibilidad debe ser una lista de días de la semana.',
            'VOL_dias_semana_dispo.*.in' => 'El campo Disponibilidad contiene un valor inválido.',
            'imagen_perfil.image' => 'El archivo debe ser una imagen.',
            'imagen_perfil.mimes' => 'El archivo debe ser de tipo: jpeg, png, jpg o gif.',
            'imagen_perfil.max' => 'El tamaño máximo del archivo es de 2048 kilobytes (2MB).',
            'DEL_id.exists' => 'La delegación seleccionada no es válida.',
            'COO_id.exists' => 'El coordinador seleccionado no es válido.',

        ]);

    }


}


