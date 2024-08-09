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
        Schema::create('planillas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('trabajador_id')->unsigned();
            $table->foreign('trabajador_id')->references('id')->on('trabajadores')->onDelete('cascade');
            $table->bigInteger('proveedores_id')->unsigned();
            $table->foreign('proveedores_id')->references('id')->on('proveedores')->onDelete('cascade');
            $table->string('codigo', 100)->default('');
            $table->string('area', 250)->default('');
            $table->date('fecha')->nullable();
            $table->boolean('desayuno')->default(false);
            $table->boolean('almuerzo')->default(false);
            $table->boolean('cena')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planillas');
    }
};
