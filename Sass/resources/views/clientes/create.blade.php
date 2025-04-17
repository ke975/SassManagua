@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Nuevo Cliente</h1>

    <form action="{{ route('clientes.store') }}" method="POST">
        @csrf
        @include('clientes.form')
        <button class="btn btn-success">Guardar</button>
        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
