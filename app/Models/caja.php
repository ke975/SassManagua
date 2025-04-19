<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombreCaja',
        'fecha_apertura',
        'fecha_cierre',
        'estado',
        'usuario_apertura',
        'usuario_cierre',
        'tipo_cierre',
        'tipo_apertura',
        'monto_actual',
    ];

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    

}
