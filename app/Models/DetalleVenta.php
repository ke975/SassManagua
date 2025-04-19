<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;
    

    protected $fillable = ['venta_id', 'inventario_id', 'cantidad', 'precio_unitario'];

    public function inventario()
    {
        return $this->belongsTo(Inventario::class);
    }

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
}
