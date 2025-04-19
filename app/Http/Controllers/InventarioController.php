<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Bodega;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    // Mostrar todos los inventarios
    public function index()
    {
        $inventarios = Inventario::with('bodega')->get(); // Traer inventarios junto con la relación 'bodega'
        return view('inventario.index', compact('inventarios'));
    }

    // Mostrar el formulario de creación de inventarios
    public function create()
    {
        $bodegas = Bodega::all(); // Traer todas las bodegas
        return view('inventario.create', compact('bodegas'));
    }

    // Guardar un nuevo producto en el inventario
    public function store(Request $request)
{
    $request->validate([
        'bodega_id' => 'required|exists:bodegas,id',
        'codigo_barra' => 'required|string',
        'nombre_producto' => 'required|string',
        'precio' => 'required|numeric',
        'stock' => 'required|integer|min:1'
    ]);

    // Buscar producto existente en la misma bodega por código de barras
    $productoExistente = Inventario::where('codigo_barra', $request->codigo_barra)
        ->where('bodega_id', $request->bodega_id)
        ->first();

    if ($productoExistente) {
        // Aumentar el stock del producto existente
        $productoExistente->stock += $request->stock;

        // Actualizar el precio y el nombre si es necesario
        $productoExistente->nombre_producto = $request->nombre_producto;
        $productoExistente->precio = $request->precio;

        $productoExistente->save();

        return redirect()->route('inventario.index')->with('success', 'Stock actualizado para el producto existente.');
    }

    // Crear un nuevo producto si no existía
    Inventario::create([
        'bodega_id' => $request->bodega_id,
        'codigo_barra' => $request->codigo_barra,
        'nombre_producto' => $request->nombre_producto,
        'precio' => $request->precio,
        'stock' => $request->stock
    ]);

    return redirect()->route('inventario.index')->with('success', 'Producto registrado correctamente.');
}

    // Mostrar el formulario de edición de inventario
    public function edit($id)
    {
        $inventario = Inventario::findOrFail($id); // Encontrar el inventario por su ID
        $bodegas = Bodega::all(); // Traer todas las bodegas
        return view('inventario.edit', compact('inventario', 'bodegas'));
    }

    // Actualizar un producto en el inventario
    public function update(Request $request, $id)
    {
        $inventario = Inventario::findOrFail($id); // Encontrar el inventario por su ID

        // Validar los datos recibidos
        $request->validate([
            'bodega_id' => 'required|exists:bodegas,id',
            'codigo_barra' => 'required|string|unique:inventarios,codigo_barra,' . $inventario->id,
            'nombre_producto' => 'required|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer|min:0'
        ]);

        // Actualizar el inventario con los nuevos datos
        $inventario->update([
            'bodega_id' => $request->bodega_id,
            'codigo_barra' => $request->codigo_barra,
            'nombre_producto' => $request->nombre_producto,
            'precio' => $request->precio,
            'stock' => $request->stock
        ]);

        return redirect()->route('inventario.index')->with('success', 'Producto actualizado');
    }

    // Eliminar un producto del inventario
    public function destroy($id)
    {
        Inventario::destroy($id); // Eliminar el inventario por su ID
        return redirect()->route('inventario.index')->with('success', 'Producto eliminado');
    }

    // Método para procesar una venta y disminuir el stock
    public function vender($id, Request $request)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1' // Validar que la cantidad sea un número mayor o igual a 1
        ]);

        $inventario = Inventario::findOrFail($id); // Encontrar el inventario por su ID

        // Verificar si hay suficiente stock para la venta
        if ($inventario->stock < $request->cantidad) {
            return back()->with('error', 'Stock insuficiente para la venta');
        }

        // Restar la cantidad vendida del stock
        $inventario->stock -= $request->cantidad;
        $inventario->save(); // Guardar los cambios en el inventario

        return back()->with('success', 'Venta realizada y stock actualizado');
    }
}
