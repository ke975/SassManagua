@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Caja</h1>
    <form action="{{ route('cajas.update', $caja->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nombreCaja">Nombre de la Caja:</label>
            <input type="text" id="nombreCaja" name="nombreCaja" class="form-control" value="{{ $caja->nombreCaja }}" required>
        </div>
        <div class="form-group">
            <label for="fecha_apertura">Fecha de Apertura:</label>
            <input type="date" id="fecha_apertura" name="fecha_apertura" class="form-control" value="{{ $caja->fecha_apertura }}">
        </div>
        <div class="form-group">
            <label for="fecha_cierre">Fecha de Cierre:</label>
            <input type="date" id="fecha_cierre" name="fecha_cierre" class="form-control" value="{{ $caja->fecha_cierre }}">
        </div>
        <div class="form-group">
            <label for="estado">Estado:</label>
            <select id="estado" name="estado" class="form-control" required>
                <option value="abierta" {{ $caja->estado == 'abierta' ? 'selected' : '' }}>Abierta</option>
                <option value="cerrada" {{ $caja->estado == 'cerrada' ? 'selected' : '' }}>Cerrada</option>
            </select>
        </div>
        <div class="form-group">
            <label for="usuario_apertura">Usuario de Apertura:</label>
            <input type="text" id="usuario_apertura" name="usuario_apertura" class="form-control" value="{{ $caja->usuario_apertura }}">
        </div>
        <div class="form-group">
            <label for="usuario_cierre">Usuario de Cierre:</label>
            <input type="text" id="usuario_cierre" name="usuario_cierre" class="form-control" value="{{ $caja->usuario_cierre }}">
        </div>
        <div class="form-group">
            <label for="tipo_apertura">Tipo de Apertura:</label>
            <select id="tipo_apertura" name="tipo_apertura" class="form-control">
                <option value="manual" {{ $caja->tipo_apertura == 'manual' ? 'selected' : '' }}>Manual</option>
                <option value="automatico" {{ $caja->tipo_apertura == 'automatico' ? 'selected' : '' }}>Automático</option>
            </select>
        </div>
        <div class="form-group">
            <label for="tipo_cierre">Tipo de Cierre:</label>
            <select id="tipo_cierre" name="tipo_cierre" class="form-control">
                <option value="manual" {{ $caja->tipo_cierre == 'manual' ? 'selected' : '' }}>Manual</option>
                <option value="automatico" {{ $caja->tipo_cierre == 'automatico' ? 'selected' : '' }}>Automático</option>
            </select>
        </div>
        <div class="form-group">
            <label for="monto_actual">Monto Actual:</label>
            <input type="number" step="0.01" id="monto_actual" name="monto_actual" class="form-control" value="{{ $caja->monto_actual }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Caja</button>
        <a href="{{ route('cajas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection