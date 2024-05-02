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
            $table->string('COO_apellidos');
            $table->string('COO_dni')->unique();
            $table->date('COO_fecha_nac');
            $table->string('COO_domicilio');
            $table->string('COO_cp');
            $table->string('COO_tel1');
            $table->enum('COO_sexo', ['Masculino', 'Femenino', 'Otro']);
            $table->string('COO_mail')->unique();
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
