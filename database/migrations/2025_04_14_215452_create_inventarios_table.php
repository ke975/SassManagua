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
        Schema::create('inventarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bodega_id');
            $table->string('codigo_barra');
            $table->string('nombre_producto');
            $table->decimal('precio', 10, 2);
            $table->integer('stock')->default(0);
            $table->timestamps();
    
            // Clave foránea para la bodega
            $table->foreign('bodega_id')->references('id')->on('bodegas')->onDelete('cascade');
    
            // Restricción de unicidad compuesta
            $table->unique(['codigo_barra', 'bodega_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventarios');
    }
};
