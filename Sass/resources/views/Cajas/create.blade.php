@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Caja</h1>
    <form action="{{ route('cajas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nombreCaja">Nombre de la Caja:</label>
            <input type="text" id="nombreCaja" name="nombreCaja" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="fecha_apertura">Fecha de Apertura:</label>
            <input type="date" id="fecha_apertura" name="fecha_apertura" class="form-control">
        </div>
        <div class="form-group">
            <label for="estado">Estado:</label>
            <select id="estado" name="estado" class="form-control" required>
                <option value="abierta">Abierta</option>
                <option value="cerrada">Cerrada</option>
            </select>
        </div>
        <div class="form-group">
            <label for="usuario_apertura">Usuario de Apertura:</label>
            <input type="text" id="usuario_apertura" name="usuario_apertura" class="form-control">
        </div>
        <div class="form-group">
            <label for="tipo_apertura">Tipo de Apertura:</label>
            <select id="tipo_apertura" name="tipo_apertura" class="form-control">
                <option value="manual">Manual</option>
                <option value="automatico">Automático</option>
            </select>
        </div>
        <div class="form-group">
            <label for="monto_actual">Monto Actual:</label>
            <input type="number" step="0.01" id="monto_actual" name="monto_actual" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Crear Caja</button>
        <a href="{{ route('cajas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection