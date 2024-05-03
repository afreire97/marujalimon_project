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
        Schema::create('imagen_lugares', function (Blueprint $table) {
            $table->id('IMG_LUG_id');
            $table->foreignId('IMG_lugar_id')->nullable()->constrained('lugares', 'LUG_id')->onDelete('cascade');
            $table->string('IMG_path');
            $table->timestamps();;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagen_lugars');
    }
};
