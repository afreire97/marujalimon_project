<?php
namespace App\Http\Utils;


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
            'VOL_localidad' => 'Localidad',
            'VOL_provincia' => 'Provincia',
            'VOL_tel' => 'Teléfono',
            'VOL_mail' => 'Correo Electrónico',
            'VOL_trabajo_actual' => 'Trabajo Actual',
            'VOL_fecha_inicio' => 'Fecha de Inicio',
            'VOL_preferencia' => 'Preferencia',
            'VOL_carnet' => 'Carnet',
            'VOL_seguro' => 'Seguro',
            'VOL_curso' => 'Curso',
            'VOL_autoriza_datos' => 'Autoriza Datos',
            'VOL_autoriza_imagen' => 'Autoriza Imagen',
            'VOL_sexo' => 'Sexo',
            'VOL_dias_semana_dispo' => 'Días de la Semana Disponibles',
            'imagen_perfil' => 'Imagen de Perfil',
            
            'password' => 'Contraseña',
            'password2' => 'Confirmar contraseña',

        ];
    }

}




