<!-- resources/views/ventas/show.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles de la Venta #{{ $venta->id }}</h1>

    <div>
        <strong>Cliente:</strong> {{ $venta->cliente->nombre }} <br>
        <strong>Caja:</strong> {{ $venta->caja->nombreCaja }} <br>
        <strong>Total:</strong> ${{ number_format($venta->total, 2) }} <br>
        <strong>Fecha:</strong> {{ $venta->fecha }} <br>
    </div>

    <h3>Productos Vendidos</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($venta->detalles as $detalle)
                <tr>
                    <td>{{ $detalle->producto->nombre_producto }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>${{ number_format($detalle->precio_unitario, 2) }}</td>
                    <td>${{ number_format($detalle->cantidad * $detalle->precio_unitario, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('ventas.index') }}" class="btn btn-secondary">Volver al Listado</a>
</div>
@endsection
