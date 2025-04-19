@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Listado de Cajas</h1>
        <a href="{{ route('cajas.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Crear Nueva Caja
        </a>
    </div>

    <div class="table-responsive shadow-sm rounded bg-white p-3">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>Monto Actual</th>
                    <th>Fecha Apertura</th>
                    <th>Fecha Cierre</th>
                    <th>Usuario Apertura</th>
                    <th>Usuario Cierre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cajas as $caja)
                <tr class="text-center">
                    <td>{{ $caja->id }}</td>
                    <td>{{ $caja->nombreCaja }}</td>
                    <td>
                        <span class="badge bg-{{ $caja->estado === 'abierta' ? 'success' : 'secondary' }}">
                            {{ ucfirst($caja->estado) }}
                        </span>
                    </td>
                    <td>${{ number_format($caja->monto_actual, 2) }}</td>
                    <td>{{ $caja->fecha_apertura ?? '-' }}</td>
                    <td>{{ $caja->fecha_cierre ?? '-' }}</td>
                    <td>{{ $caja->usuario_apertura ?? '-' }}</td>
                    <td>{{ $caja->usuario_cierre ?? '-' }}</td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('cajas.edit', $caja->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>
                            <form action="{{ route('cajas.destroy', $caja->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta caja?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash3"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted">No hay cajas registradas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{ $cajas->links('pagination::bootstrap-5') }}

    </div>
</div>
@endsection
