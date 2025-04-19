@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Inventario</h2>

    <a href="{{ route('inventario.create') }}" class="btn btn-success mb-3">Agregar Producto</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Código</th>
                <th>Producto</th>
                <th>Precio</th>
                <th>Bodega</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventarios as $inv)
            <tr>
                <td>{{ $inv->codigo_barra }}</td>
                <td>{{ $inv->nombre_producto }}</td>
                <td>${{ $inv->precio }}</td>
                <td>{{ $inv->bodega->nombre }}</td>
                <td>{{ $inv->stock}}</td>
                <td>
                    <a href="{{ route('inventario.edit', $inv->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('inventario.destroy', $inv->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
