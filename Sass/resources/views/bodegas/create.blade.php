@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Nueva Bodega</h1>

    <form action="{{ route('bodegas.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
            @error('nombre')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-success">Guardar</button>
        <a href="{{ route('bodegas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
