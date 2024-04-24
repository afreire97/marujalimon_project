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
        Schema::create('imagen_perfiles', function (Blueprint $table) {
            $table->id('IMG_id');
            $table->foreignId('IMG_voluntario_id')->nullable()->constrained('voluntarios', 'VOL_id')->onDelete('cascade');
            $table->foreignId('IMG_coordinador_id')->nullable()->constrained('coordinadores', 'COO_id')->onDelete('cascade');
            $table->string('IMG_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagen_perfiles');
    }
};
