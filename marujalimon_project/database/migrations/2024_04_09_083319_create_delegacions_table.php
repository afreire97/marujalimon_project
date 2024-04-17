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
        Schema::create('delegaciones', function (Blueprint $table) {
            $table->id('DEL_id');
            $table->string('DEL_nombre');
            $table->string('DEL_localidad')->unique();
            $table->foreignId('DEL_provincia_id')->constrained('provincias', 'PRO_id')->onDelete('cascade');



            $table->timestamps();
        });
        Schema::create('coordinador_delegacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('COO_DEL_coordinador_id')->constrained('coordinadores', 'COO_id')->onDelete('cascade');
            $table->foreignId('COO_DEL_delegacion_id')->constrained('delegaciones', 'DEL_id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delegaciones');
    }
};
