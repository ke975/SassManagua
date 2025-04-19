<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('telefono')->nullable();
            $table->string('direccion')->nullable();
            $table->string('dni')->unique()->nullable(); // o cedula/RUC
            $table->string('tipo')->default('consumidor_final'); // ej: consumidor_final, empresa
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};

