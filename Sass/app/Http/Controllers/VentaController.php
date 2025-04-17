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
    public function index(Request $request)
    {
        $fecha = $request->input('fecha') ?? Carbon::today()->toDateString();
        $cliente = $request->input('cliente');
    
        $ventasQuery = Venta::with('cliente', 'caja')
            ->whereDate('created_at', $fecha);
    
        // Si hay filtro por cliente, aplicarlo
        if (!empty($cliente)) {
            $ventasQuery->whereHas('cliente', function ($q) use ($cliente) {
                $q->where('nombre', 'like', '%' . $cliente . '%');
            });
        }
    
        $ventas = $ventasQuery->orderBy('created_at', 'desc')->paginate(20);
    
        // Para mostrar resumen de ventas por día
        $ventasPorDia = Venta::select(DB::raw('DATE(created_at) as fecha'), DB::raw('SUM(total) as total_ventas'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('fecha', 'desc')
            ->get();
            
    
        // Total solo de las ventas que coincidan con el filtro actual
        $totalHoy = $ventasQuery->sum('total');
    
        return view('ventas.index', compact('ventas', 'ventasPorDia', 'totalHoy', 'fecha', 'cliente'));
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
        $venta = Venta::findOrFail($id);
    
        $request->validate([
            'caja_id' => 'required|exists:cajas,id',
            'total' => 'required|numeric|min:0.01',
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:inventarios,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
        ]);
    
        // Guarda valores anteriores
        $cajaAnteriorId = $venta->caja_id;
        $totalAnterior = $venta->total;
    
        // Actualizar la venta
        $venta->update([
            'caja_id' => $request->caja_id,
            'total' => $request->total,
        ]);
    
        // Actualizar el monto en la(s) caja(s)
        if ($cajaAnteriorId != $request->caja_id) {
            // Si cambió de caja, revertimos en la anterior y sumamos en la nueva
            $cajaAnterior = Caja::find($cajaAnteriorId);
            $cajaNueva = Caja::findOrFail($request->caja_id);
    
            if ($cajaAnterior) {
                $cajaAnterior->decrement('monto_actual', $totalAnterior);
            }
    
            $cajaNueva->increment('monto_actual', $request->total);
        } else {
            // Si es la misma caja, solo ajustamos el total
            $diferencia = $request->total - $totalAnterior;
            $caja = Caja::findOrFail($request->caja_id);
            $caja->increment('monto_actual', $diferencia);
        }
    
        // Obtener IDs actuales
        $productoIds = collect($request->productos)->pluck('id')->toArray();
    
        // Eliminar detalles que ya no están
        $venta->detalles()->whereNotIn('producto_id', $productoIds)->delete();
    
        // Procesar productos
        foreach ($request->productos as $productoData) {
            $productoId = $productoData['id'];
            $nuevaCantidad = $productoData['cantidad'];
    
            $detalleExistente = $venta->detalles()->where('producto_id', $productoId)->first();
            $inventario = Inventario::findOrFail($productoId);
    
            if ($detalleExistente) {
                $inventario->stock += $detalleExistente->cantidad;
            }
    
            $inventario->stock -= $nuevaCantidad;
            $inventario->save();
    
            $venta->detalles()->updateOrCreate(
                ['producto_id' => $productoId],
                [
                    'cantidad' => $nuevaCantidad,
                    'precio_unitario' => $productoData['precio_unitario'],
                ]
            );
        }
    
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
