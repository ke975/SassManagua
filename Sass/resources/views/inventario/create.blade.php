@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Agregar Producto</h2>

    <form action="{{ route('inventario.store') }}" method="POST">
        @csrf
        @include('inventario.form')
    </form>
</div>
@endsection
