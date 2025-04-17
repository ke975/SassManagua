<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('venta_detalles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('venta_id');
            $table->unsignedBigInteger('producto_id'); // <- Esto referencia a 'inventarios'
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->timestamps();

            // Relaciones
            $table->foreign('venta_id')->references('id')->on('ventas')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('inventarios')->onDelete('cascade'); // <- CORREGIDO
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('venta_detalles');
    }
};
