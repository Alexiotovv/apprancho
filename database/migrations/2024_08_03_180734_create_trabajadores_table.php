<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('trabajadores', function (Blueprint $table) {
            $table->id();
            $table->string('documento', 100)->default('');
            $table->string('nombre', 250)->default('');
            $table->string('apellido', 250)->default('');
            $table->string('cargo', 250)->default('');
            $table->boolean('estado')->default(false);
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('trabajadores');
    }
};
