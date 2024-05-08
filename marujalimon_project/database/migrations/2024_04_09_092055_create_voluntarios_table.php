<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('voluntarios', function (Blueprint $table) {
            $table->id('VOL_id');
            $table->string('VOL_nombre');

            //nullable
            $table->string('VOL_apellidos');


            $table->string('VOL_dni')->unique();
            $table->date('VOL_fecha_nac');
            ;
            $table->string('VOL_domicilio');
            $table->string('VOL_cp');




            $table->string('VOL_localidad');
            $table->string('VOL_provincia');
            $table->string('VOL_tel');
            // $table->enum('VOL_sexo', ['Masculino', 'Femenino', 'Otro']);
            $table->string('VOL_mail')->unique();
            $table->string('VOL_trabajo_actual');
            $table->date('VOL_fecha_inicio');
            $table->string('VOL_preferencia');

            $table->boolean('VOL_carnet');
            $table->boolean('VOL_seguro');
            $table->string('VOL_curso')->nullable();
            $table->boolean('VOL_autoriza_datos');
            $table->boolean('VOL_autoriza_imagen');
            $table->string('VOL_sexo');

            //LUEGO ARREGLAR EL NULLABLE


            $table->set('VOL_dias_semana_dispo', ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'])
            ->nullable();
            $table->timestamps();

            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Relación con usuarios


        });
        Schema::create('coordinador_voluntario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('COO_VOL_coordinador_id')->constrained('coordinadores', 'COO_id')->onDelete('cascade');
            $table->foreignId('COO_VOL_voluntario_id')->constrained('voluntarios', 'VOL_id')->onDelete('cascade');
            $table->timestamps();


        });
        Schema::create('delegacion_voluntario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('DEL_VOL_delegacion_id')->constrained('delegaciones', 'DEL_id')->onDelete('cascade');
            $table->foreignId('DEL_VOL_voluntario_id')->constrained('voluntarios', 'VOL_id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('VOLUNTARIOS');
    }
};
