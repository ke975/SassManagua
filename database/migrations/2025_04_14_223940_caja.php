<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cajas', function (Blueprint $table) {
            $table->id();
            $table->string('nombreCaja')->default('Caja sin nombre');
            $table->string('fecha_apertura')->nullable();
            $table->string('fecha_cierre')->nullable();
            $table->string('estado')->default('abierta'); // abierta, cerrada
            $table->string('usuario_apertura')->nullable();
            $table->string('usuario_cierre')->nullable();
            $table->string('tipo_cierre')->nullable(); // manual, automatico
            $table->string('tipo_apertura')->nullable(); // manual, automatico
         
         // manual, automatico
            $table->decimal('monto_actual', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
