@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Listado de Cajas</h1>
    <a href="{{ route('cajas.create') }}" class="btn btn-success mb-3">Crear Nueva Caja</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Monto Actual</th>
                <th>Fecha Apertura</th>
                <th>Fecha Cierre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cajas as $caja)
            <tr>
                <td>{{ $caja->id }}</td>
                <td>{{ $caja->nombreCaja }}</td>
                <td>{{ $caja->estado }}</td>
                <td>{{ $caja->monto_actual }}</td>
                <td>{{ $caja->fecha_apertura }}</td>
                <td>{{ $caja->fecha_cierre }}</td>
                <td>
                    <a href="{{ route('cajas.edit', $caja->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('cajas.destroy', $caja->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection