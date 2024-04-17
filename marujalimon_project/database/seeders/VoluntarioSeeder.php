<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VoluntarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
     public function run()
     {
         for ($i = 0; $i < 50; $i++) {
             DB::table('voluntarios')->insert([
                 'VOL_nombre' => 'Voluntario de prueba ' . $i,
                 'VOL_apellidos' => 'Apellidos de prueba ' . $i,
                 'VOL_dni' => str_pad($i, 8, '0', STR_PAD_LEFT) . 'A', // Genera un DNI único
                 'VOL_fecha_nac' => '2000-01-01',
                 'VOL_domicilio' => 'Domicilio de prueba ' . $i,
                 'VOL_cp' => '12345',
                 'VOL_tel1' => '123456789', // Añade un valor para 'VOL_tel1'
                 'VOL_mail' => 'test' . $i . '@example.com', // Añade un valor para 'VOL_mail'
             ]);
         }
     }
}