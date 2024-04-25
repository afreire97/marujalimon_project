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




