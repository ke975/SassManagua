@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Panel de Control</h1>

    @php
        $role = auth()->user()->role;
    @endphp

    <div class="row row-cols-1 row-cols-md-4 g-4">

        {{-- ADMIN: ve todo --}}
        @if($role === 'admin')
            <div class="col">
                <div class="card border-primary shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-truck fs-1 text-primary"></i>
                        <h5 class="card-title mt-2">Proveedores</h5>
                        <a href="#" class="btn btn-outline-primary btn-sm mt-2">Ir</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card border-success shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-people fs-1 text-success"></i>
                        <h5 class="card-title mt-2">Clientes</h5>
                        <a href="#" class="btn btn-outline-success btn-sm mt-2">Ir</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card border-warning shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-wallet2 fs-1 text-warning"></i>
                        <h5 class="card-title mt-2">Cuentas por Pagar</h5>
                        <a href="#" class="btn btn-outline-warning btn-sm mt-2">Ir</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card border-danger shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-receipt fs-1 text-danger"></i>
                        <h5 class="card-title mt-2">Ventas</h5>
                        <a href="#" class="btn btn-outline-danger btn-sm mt-2">Ir</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card border-info shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-box-seam fs-1 text-info"></i>
                        <h5 class="card-title mt-2">Bodega</h5>
                        <a href="#" class="btn btn-outline-info btn-sm mt-2">Ir</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card border-secondary shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-clipboard-data fs-1 text-secondary"></i>
                        <h5 class="card-title mt-2">Inventario</h5>
                        <a href="#" class="btn btn-outline-secondary btn-sm mt-2">Ir</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card border-dark shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-globe fs-1 text-dark"></i>
                        <h5 class="card-title mt-2">Ventas en Línea</h5>
                        <a href="#" class="btn btn-outline-dark btn-sm mt-2">Ir</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card border-primary shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-cash-stack fs-1 text-primary"></i>
                        <h5 class="card-title mt-2">Caja</h5>
                        <a href="#" class="btn btn-outline-primary btn-sm mt-2">Ir</a>
                    </div>
                </div>
            </div>
        @endif

        {{-- VENDEDOR: solo ventas --}}
        @if($role === 'vendedor')
            <div class="col">
                <div class="card border-danger shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-receipt fs-1 text-danger"></i>
                        <h5 class="card-title mt-2">Ventas</h5>
                        <a href="#" class="btn btn-outline-danger btn-sm mt-2">Ir</a>
                    </div>
                </div>
            </div>
        @endif

        @if($role === 'bodeguero')
    <div class="col">
        <div class="card border-info shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-box-seam fs-1 text-info"></i>
                <h5 class="card-title mt-2">Bodega</h5>
                <a href="{{ route('bodeguero.panel') }}" class="btn btn-outline-info btn-sm mt-2">Ir</a>
            </div>
        </div>
    </div>
@endif


    </div>
</div>
@endsection
