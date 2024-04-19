<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('horas_voluntariado', function (Blueprint $table) {
            $table->id('HOR_id');
            $table->foreignId('HOR_voluntario_id')->constrained('voluntarios', 'VOL_id')->onDelete('cascade');
            $table->integer('HOR_horas'); // Agrega un campo para la cantidad de horas
            $table->dateTime('HOR_fecha_inicio'); // Campo para guardar la fecha de inicio de la actividad
            $table->foreignId('HOR_tarea_id')->constrained('tareas', 'TAR_id')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horas');
    }
};
