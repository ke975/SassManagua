@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Clientes</h1>

    <a href="{{ route('clientes.create') }}" class="btn btn-primary mb-3">Nuevo Cliente</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>DNI</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clientes as $cliente)
            <tr>
                <td>{{ $cliente->nombre }} {{ $cliente->apellido }}</td>
                <td>{{ $cliente->email }}</td>
                <td>{{ $cliente->dni }}</td>
                <td>{{ $cliente->telefono }}</td>
                <td>
                    <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro?')">
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
