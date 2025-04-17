@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">📊 Reporte de Ventas</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="GET" action="{{ route('ventas.index') }}" class="row g-3 align-items-center mb-4">
        <div class="col-md-3">
            <label for="fecha" class="form-label">Filtrar por fecha:</label>
            <input type="date" id="fecha" name="fecha" value="{{ $fecha }}" class="form-control">
        </div>
        <div class="col-md-4">
            <label for="cliente" class="form-label">Filtrar por cliente:</label>
            <input type="text" id="cliente" name="cliente" value="{{ $cliente }}" class="form-control" placeholder="Nombre del cliente">
        </div>
        <div class="col-md-2 align-self-end">
            <button type="submit" class="btn btn-primary w-100">Buscar</button>
        </div>
    </form>
    
    
    {{-- Total del día --}}
    <div class="alert alert-primary text-center">
        <strong>Total de ventas hoy ({{ \Carbon\Carbon::today()->format('d/m/Y') }}):</strong>
        <span class="fs-5 text-success">${{ number_format($totalHoy, 2) }}</span>
    </div>

    <div class="row">
        {{-- Gráfico --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-center">📈 Ventas por Día</h5>
                    <canvas id="graficoVentas" height="220"></canvas>
                </div>
            </div>
        </div>

        {{-- Tabla --}}
        <div class="col-md-6">
            <div class="table-responsive card shadow-sm">
                <table class="table table-bordered table-hover m-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Caja</th>
                            <th>Total</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ventas as $venta)
                            <tr>
                                <td>{{ $venta->id }}</td>
                                <td>{{ $venta->cliente->nombre }}</td>
                                <td>{{ $venta->caja->nombreCaja }}</td>
                                <td>${{ number_format($venta->total, 2) }}</td>
                                <td>{{ \Carbon\Carbon::parse($venta->created_at)->format('d/m/Y H:i') }}</td>
                                <td class="d-flex gap-1">
                                    <a href="{{ route('ventas.show', $venta->id) }}" class="btn btn-sm btn-outline-info">Ver</a>
                                    <a href="{{ route('ventas.edit', $venta->id) }}" class="btn btn-sm btn-outline-warning">Editar</a>
                                    <form action="{{ route('ventas.destroy', $venta->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta venta?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No hay ventas registradas para los filtros seleccionados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $ventas->appends(['fecha' => $fecha, 'cliente' => $cliente])->links(('pagination::bootstrap-5')) }}
            
            
        </div>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('graficoVentas').getContext('2d');
    const ventasData = @json($ventasPorDia);

    const labels = ventasData.map(v => v.fecha);
    const data = ventasData.map(v => v.total_ventas);

    new Chart(ctx, {
        type: 'polarArea',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Ventas',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                borderRadius: 5
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => `$${value}`
                    }
                }
            }
        }
    });
</script>
@endsection
