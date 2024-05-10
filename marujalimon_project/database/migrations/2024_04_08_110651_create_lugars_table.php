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
        Schema::create('lugares', function (Blueprint $table) {
            $table->id('LUG_id');
            $table->integer('LUG_cp');
            $table->string('LUG_Localidad');
            $table->string('LUG_Delegacion');
            $table->string('LUG_nombre');
            $table->string('LUG_direccion')->nullable();
            $table->string('LUG_url_maps')->nullable();



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lugars');
    }
};
