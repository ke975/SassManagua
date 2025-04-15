@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Producto</h2>

    <form action="{{ route('inventario.update', $inventario->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('inventario.form', ['inventario' => $inventario])
    </form>
</div>
@endsection
