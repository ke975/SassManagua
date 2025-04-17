<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\VentaDetalle;
use App\Models\Inventario;
use App\Models\Cliente;
use App\Models\Caja;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VentaController extends Controller
{
    // Mostrar todas las ventas
    public function index()
    {
        $ventas = Venta::with('cliente', 'caja')->get();

        // Agrupar ventas por fecha
        $ventasPorDia = Venta::select(DB::raw('DATE(created_at) as fecha'), DB::raw('SUM(total) as total_ventas'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('fecha', 'desc')
            ->get();
    
        // Total del día actual
        $hoy = Carbon::today()->toDateString();
        $totalHoy = Venta::whereDate('created_at', $hoy)->sum('total');
    
        return view('ventas.index', compact('ventas', 'ventasPorDia', 'totalHoy'));
    }

    // Mostrar el formulario de creación
    public function create()
    {
        $productos = Inventario::all(); // Productos disponibles
        $clientes = Cliente::all();     // Clientes
        $cajas = Caja::where('estado', 'abierta')->get(); // Solo cajas abiertas

        return view('ventas.create', compact('productos', 'clientes', 'cajas'));
    }

    // Guardar una venta
    public function store(Request $request)
    {
        $request->validate([
            'caja_id' => 'required|exists:cajas,id',
            'total' => 'required|numeric|min:0.01',
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:inventarios,id',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        // Crear la venta
        $venta = Venta::create([
            'user_id' => Auth::id(),
            'cliente_id' => $request->cliente_id,
            'caja_id' => $request->caja_id,
            'total' => $request->total,
            'fecha' => now(),
        ]);

        // Agregar detalles y actualizar stock
        foreach ($request->productos as $detalle) {
            $producto = Inventario::findOrFail($detalle['id']);

            if ($producto->stock < $detalle['cantidad']) {
                return back()->withErrors("Stock insuficiente para el producto: {$producto->nombre}");
            }

            // Crear detalle
            VentaDetalle::create([
                'venta_id' => $venta->id,
                'producto_id' => $producto->id,
                'cantidad' => $detalle['cantidad'],
                'precio_unitario' => $producto->precio,
            ]);

            // Descontar del inventario
            $producto->decrement('stock', $detalle['cantidad']);
        }

        // Sumar al monto actual de la caja
        $caja = Caja::findOrFail($request->caja_id);
        $caja->increment('monto_actual', $request->total);

        

        return redirect()->route('ventas.factura', $venta->id);



    }

    // Ver detalles de una venta
    public function show($id)
    {
        $venta = Venta::with(['detalles.producto', 'cliente', 'caja'])->findOrFail($id);
        return view('ventas.show', compact('venta'));
    }



    // Mostrar el formulario de edición


    public function edit($id)
    {
        $venta = Venta::with(['detalles.producto', 'cliente', 'caja'])->findOrFail($id);
        $productos = \App\Models\Inventario::all();
        $cajas = \App\Models\Caja::all();
    
        return view('ventas.edit', compact('venta', 'productos', 'cajas'));
    }
    


    public function update(Request $request, $id)
    {
        // Encontramos la venta a actualizar
        $venta = Venta::findOrFail($id);
    
        // Validación
        $request->validate([
            'caja_id' => 'required|exists:cajas,id',
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:inventarios,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
        ]);
    
        // Actualizamos la venta con los nuevos datos
        $venta->update([
            'caja_id' => $request->caja_id,
            'total' => $request->total,  // El total debe ser calculado antes de ser enviado
        ]);
    
        // Obtener los IDs de productos actuales (de inventarios)
        $productoIds = collect($request->productos)->pluck('id')->toArray();
    
        // Eliminar los detalles de productos que ya no están en la venta
        $venta->detalles()->whereNotIn('producto_id', $productoIds)->delete();
    
        // Actualizar o crear detalles de venta para cada producto
        foreach ($request->productos as $productoData) {
            // Obtener el detalle existente (si lo hay)
            $detalleExistente = $venta->detalles()->where('producto_id', $productoData['id'])->first();
    
            // Ajustar el stock del inventario
            $inventario = Inventario::findOrFail($productoData['id']);
            if ($detalleExistente) {
                // Si el detalle ya existía, revertimos el stock anterior
                $inventario->stock += $detalleExistente->cantidad;
            }
            // Reducimos el stock según la nueva cantidad
            $inventario->stock -= $productoData['cantidad'];
            $inventario->save();
    
            // Usamos `updateOrCreate` para actualizar o crear el detalle
            $venta->detalles()->updateOrCreate(
                ['producto_id' => $productoData['id']], // Validamos si el producto ya existe en los detalles
                [
                    'cantidad' => $productoData['cantidad'], 
                    'precio_unitario' => $productoData['precio_unitario']  // Guardamos el precio unitario
                ]
            );
        }
    
        // Redirigimos al listado de ventas con un mensaje de éxito
        return redirect()->route('ventas.index')->with('success', 'Venta actualizada con éxito');
    }
    
    
    


    // Eliminar una venta (opcional)
    public function destroy($id)
    {
        $venta = Venta::with('detalles')->findOrFail($id);

        // Restaurar stock
        foreach ($venta->detalles as $detalle) {
            $detalle->producto->increment('stock', $detalle->cantidad);
        }

        // Disminuir caja
        $venta->caja->decrement('monto_actual', $venta->total);

        // Eliminar venta y detalles
        VentaDetalle::where('venta_id', $venta->id)->delete();
        $venta->delete();

        return redirect()->route('ventas.index')->with('success', 'Venta eliminada y stock restaurado.');
    }


    public function factura($id)
{
    $venta = Venta::with(['cliente', 'detalles.producto', 'caja'])->findOrFail($id);
    return view('ventas.factura', compact('venta'));
}

}
