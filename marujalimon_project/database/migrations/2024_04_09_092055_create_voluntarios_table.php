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
            $table->string('VOL_apellidos')->nullable();


            $table->string('VOL_dni')->unique();
            $table->date('VOL_fecha_nac')->nullable();
            ;
            $table->string('VOL_domicilio')->nullable();
            $table->string('VOL_cp')->nullable();
            $table->string('VOL_tel1')->nullable();
            $table->enum('VOL_sexo', ['Masculino', 'Femenino', 'Otro'])->nullable();
            $table->string('VOL_mail')->unique();


            //LUEGO ARREGLAR EL NULLABLE
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Relación con usuarios


            $table->timestamps();


            $table->date('VOL_fecha_baja')->nullable();
            $table->string('VOL_col_pref')->nullable();




            $table->string('VOL_carnet')->nullable();
            $table->string('VOL_seguro')->nullable();
            $table->string('VOL_seguro_exento')->nullable();
            $table->string('VOL_cdns')->nullable();
            $table->string('VOL_cdns_pdf')->nullable();

            $table->string('VOL_curso')->nullable();
            $table->boolean('VOL_tiene_usuario')->nullable();
            $table->string('VOL_demandas')->nullable();
            $table->boolean('VOL_autoriza_datos')->nullable();
            $table->string('VOL_lugar_voluntariado')->nullable();
             //todo comprobar que se pueden poner mas de un dia a la semana
            $table->set('VOL_dias_semana_dispo', ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'])
            ->nullable();


            $table->boolean('VOL_dispo_dot')->nullable();
            $table->boolean('VOL_dispo_cubierta')->nullable();
            $table->boolean('VOL_autoriza_uso_imagen')->nullable();
            $table->boolean('VOL_autoriza_uso_imagen_cubierto')->nullable();
            $table->boolean('VOL_for_for_inicial')->nullable();
            $table->boolean('VOL_for_mayores')->nullable();
            $table->boolean('VOL_for_menores')->nullable();
            $table->boolean('VOL_for_discapacidad')->nullable();
            $table->boolean('VOL_for_otras')->nullable();



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
