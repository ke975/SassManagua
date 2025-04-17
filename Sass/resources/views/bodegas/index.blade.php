@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lista de Bodegas</h1>

    <a href="{{ route('bodegas.create') }}" class="btn btn-primary mb-3">Nueva Bodega</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bodegas as $bodega)
                <tr>
                    <td>{{ $bodega->nombre }}</td>
                    <td>
                        <a href="{{ route('bodegas.edit', $bodega) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('bodegas.destroy', $bodega) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
