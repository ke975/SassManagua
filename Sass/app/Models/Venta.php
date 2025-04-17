<?php

// app/Models/Venta.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'cliente_id', 'caja_id', 'total', 'fecha'
    ];

    // Relación con Caja
    public function caja()
    {
        return $this->belongsTo(Caja::class);
    }

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relación con los detalles de la venta
    public function detalles()
    {
        return $this->hasMany(VentaDetalle::class, );
    }

    // Método para actualizar el monto de la caja
    public static function actualizarMontoCaja($venta)
    {
        $caja = Caja::find($venta->caja_id);
        if ($caja) {
            // Sumamos el total de la venta al monto actual de la caja
            $caja->monto_actual += $venta->total;
            $caja->save();
        }
    }
}
