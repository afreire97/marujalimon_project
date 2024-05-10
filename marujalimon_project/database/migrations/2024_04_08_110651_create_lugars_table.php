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
            $table->integer('LUG_cp')->nullable();
            $table->string('LUG_localidad')->nullable();
            $table->string('LUG_provincia')->nullable();
            $table->string('LUG_delegacion')->nullable();
            $table->string('LUG_nombre')->nullable();
            $table->string('LUG_direccion')->nullable();
            $table->string('LUG_url_maps')->nullable()->default('https://maps.app.goo.gl/7tATAr8gv1oj2CXu8');



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
