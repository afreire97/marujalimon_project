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
        Schema::create('coordinadores', function (Blueprint $table) {
            $table->id('COO_id');

            $table->string('COO_nombre');
            //nullable
            $table->string('COO_apellidos');
            $table->string('COO_dni')->unique();
            $table->date('COO_fecha_nac');
            $table->string('COO_domicilio');
            $table->string('COO_cp');
            $table->string('COO_localidad');
            $table->string('COO_provincia');
            $table->string('COO_tel');
            // $table->enum('VOL_sexo', ['Masculino', 'Femenino', 'Otro']);
            $table->string('COO_mail')->unique();
            $table->string('COO_trabajo_actual');
            $table->date('COO_fecha_inicio');
            $table->string('COO_preferencia');
            $table->boolean('COO_carnet');
            $table->boolean('COO_seguro');
            $table->string('COO_curso')->nullable();
            $table->boolean('COO_autoriza_datos');
            $table->boolean('COO_autoriza_imagen');
            $table->string('COO_sexo');



            $table->set('COO_dias_semana_dispo', ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'])
            ->nullable();

            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Relación con usuarios
            $table->timestamps();

        });
        Schema::create('coordinador_lugar', function (Blueprint $table) {
            $table->id('COO_LUG_id');
            $table->foreignId('COO_LUG_coordinador_id')->nullable()->constrained('coordinadores', 'COO_id')->onDelete('cascade');
            $table->foreignId('COO_LUG_lugar_id')->nullable()->constrained('lugares', 'LUG_id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coordinadores');
    }
};
