<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;
    protected $fillable = [
        'bodega_id',
        'nombre_producto',
        'precio',
        'codigo_barra',
        'stock',
    ];

    
    public function bodega()
    {
        return $this->belongsTo(Bodega::class);
    }

    public function ventas()
{
    return $this->hasMany(Venta::class);
}

public function detallesVenta()
{
    return $this->hasMany(DetalleVenta::class);
}

}
