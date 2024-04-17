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
        Schema::create('tareas', function (Blueprint $table) {
            $table->id('TAR_id');
            $table->string('TAR_nombre');
            $table->string('TAR_descripcion');
            $table->foreignId('TAR_lugar_id')->constrained('lugares', 'LUG_id')->cascadeOnDelete();
            $table->timestamps();
        });
        Schema::create('tarea_voluntario', function (Blueprint $table) {
            $table->id('TAR_VOL_id');
            $table->foreignId('TAR_VOL_tarea_id')->constrained('tareas', 'TAR_id')->cascadeOnDelete();
            $table->foreignId('TAR_VOL_voluntario_id')->constrained('voluntarios', 'VOL_id')->cascadeOnDelete();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};
