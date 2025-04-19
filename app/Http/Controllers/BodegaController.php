<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bodega;

class BodegaController extends Controller
{
    public function index()
    {
        $bodegas = Bodega::all();
        return view('bodegas.index', compact('bodegas')); // te faltaba pasar la variable
    }

    public function create()
    {
        return view('bodegas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        Bodega::create($request->all()); // Clase correcta: Bodega, no Bodegas

        return redirect()->route('bodegas.index')->with('success', 'Bodega creada correctamente');
    }

    public function edit(Bodega $bodega)
    {
        return view('bodegas.edit', compact('bodega'));
    }


    public function update (Request $request,   Bodega $bodega){
    $request->validate([
        'nombre' => 'required|string|max:255',
    ]);

    $bodega->update($request->all());

    return redirect()->route('bodegas.index')->with('success', 'Bodega creada correctamente');
    }


    public function destroy(Bodega $bodega)
    {
        $bodega->delete();
        return redirect()->route('bodegas.index')->with('success', 'Bodega eliminada correctamente');
    }



}


