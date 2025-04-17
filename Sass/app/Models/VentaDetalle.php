<?php

// app/Models/VentaDetalle.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaDetalle extends Model
{
    use HasFactory;

    protected $fillable = [
        'venta_id', 'producto_id', 'cantidad', 'precio_unitario'
    ];

    // Relación con la venta
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    // Relación con el producto
    public function producto()
    {
        return $this->belongsTo(Inventario::class, 'producto_id');
    }
}
