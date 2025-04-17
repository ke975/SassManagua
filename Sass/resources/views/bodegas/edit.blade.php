@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Bodega</h1>

    <form action="{{ route('bodegas.update', $bodega) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $bodega->nombre) }}" required>
            @error('nombre')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-primary">Actualizar</button>
        <a href="{{ route('bodegas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
