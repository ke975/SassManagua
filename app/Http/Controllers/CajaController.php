<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use Illuminate\Http\Request;

class CajaController extends Controller
{
    public function index()
    {
        $cajas = Caja::paginate(10);
        return view('cajas.index', compact('cajas'));
    }

    public function create()
    {
        return view('cajas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombreCaja' => 'required|string|max:255',
            'fecha_apertura' => 'nullable|date',
            'fecha_cierre' => 'nullable|date',
            'estado' => 'required|string|in:abierta,cerrada',
            'usuario_apertura' => 'nullable|string|max:255',
            'usuario_cierre' => 'nullable|string|max:255',
            'tipo_cierre' => 'nullable|string|max:255',
            'tipo_apertura' => 'nullable|string|max:255',
            'monto_actual' => 'required|numeric|min:0',
        ]);

        Caja::create($request->all());

        return redirect()->route('cajas.index')->with('success', 'Caja creada con éxito.');
    }

    public function edit(Caja $caja)
    {
        return view('cajas.edit', compact('caja'));
    }

    public function update(Request $request, Caja $caja)
    {
        $request->validate([
            'nombreCaja' => 'required|string|max:255',
            'fecha_apertura' => 'nullable|date',
            'fecha_cierre' => 'nullable|date',
            'estado' => 'required|string|in:abierta,cerrada',
            'usuario_apertura' => 'nullable|string|max:255',
            'usuario_cierre' => 'nullable|string|max:255',
            'tipo_cierre' => 'nullable|string|max:255',
            'tipo_apertura' => 'nullable|string|max:255',
            'monto_actual' => 'required|numeric|min:0',
        ]);

        $caja->update($request->all());

        return redirect()->route('cajas.index')->with('success', 'Caja actualizada con éxito.');
    }

    public function destroy(Caja $caja)
    {
        $caja->delete();

        return redirect()->route('cajas.index')->with('success', 'Caja eliminada con éxito.');
    }
}