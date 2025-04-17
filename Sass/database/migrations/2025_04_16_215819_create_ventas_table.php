<?php

// database/migrations/xxxx_xx_xx_create_ventas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Usuario que realizó la venta
            $table->foreignId('cliente_id')->nullable()->constrained()->onDelete('set null'); // Cliente (opcional)
            $table->foreignId('caja_id')->constrained()->onDelete('cascade'); // Caja en la que se realizó la venta
            $table->decimal('total', 10, 2); // Total de la venta
            $table->timestamp('fecha')->default(now()); // Fecha y hora de la venta
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
