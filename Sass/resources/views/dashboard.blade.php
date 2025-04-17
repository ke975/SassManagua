@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Panel de Control</h1>
    </div>

    @php
        $role = auth()->user()->role;
    @endphp

    <div class="row g-4">

        {{-- ADMIN --}}
        @if($role === 'admin')
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card text-bg-light h-100 border-primary">
                    <div class="card-body text-center">
                        <i class="bi bi-truck display-4 text-primary"></i>
                        <h5 class="card-title mt-3">Proveedores</h5>
                        <a href="/proveedores" class="btn btn-sm btn-primary mt-2">Ir</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="card text-bg-light h-100 border-success">
                    <div class="card-body text-center">
                        <i class="bi bi-people display-4 text-success"></i>
                        <h5 class="card-title mt-3">Clientes</h5>
                        <a href="#" class="btn btn-sm btn-success mt-2">Ir</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="card text-bg-light h-100 border-warning">
                    <div class="card-body text-center">
                        <i class="bi bi-wallet2 display-4 text-warning"></i>
                        <h5 class="card-title mt-3">Cuentas por Pagar</h5>
                        <a href="#" class="btn btn-sm btn-warning mt-2 text-white">Ir</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="card text-bg-light h-100 border-danger">
                    <div class="card-body text-center">
                        <i class="bi bi-receipt display-4 text-danger"></i>
                        <h5 class="card-title mt-3">Ventas</h5>
                        <a href="/ventas" class="btn btn-sm btn-danger mt-2">Ir</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="card text-bg-light h-100 border-info">
                    <div class="card-body text-center">
                        <i class="bi bi-box-seam display-4 text-info"></i>
                        <h5 class="card-title mt-3">Bodega</h5>
                        <a href="/bodegas" class="btn btn-sm btn-info mt-2 text-white">Ir</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="card text-bg-light h-100 border-secondary">
                    <div class="card-body text-center">
                        <i class="bi bi-clipboard-data display-4 text-secondary"></i>
                        <h5 class="card-title mt-3">Inventario</h5>
                        <a href="/inventario" class="btn btn-sm btn-secondary mt-2">Ir</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="card text-bg-light h-100 border-dark">
                    <div class="card-body text-center">
                        <i class="bi bi-globe display-4 text-dark"></i>
                        <h5 class="card-title mt-3">Ventas en Línea</h5>
                        <a href="#" class="btn btn-sm btn-dark mt-2">Ir</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="card text-bg-light h-100 border-primary">
                    <div class="card-body text-center">
                        <i class="bi bi-cash-stack display-4 text-primary"></i>
                        <h5 class="card-title mt-3">Caja</h5>
                        <a href="/cajas" class="btn btn-sm btn-primary mt-2">Ir</a>
                    </div>
                </div>
            </div>
        @endif

        {{-- VENDEDOR --}}
        @if($role === 'vendedor')
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card text-bg-light h-100 border-danger">
                    <div class="card-body text-center">
                        <i class="bi bi-receipt display-4 text-danger"></i>
                        <h5 class="card-title mt-3">Ventas</h5>
                        <a href="/ventas" class="btn btn-sm btn-danger mt-2">Ir</a>
                    </div>
                </div>
            </div>
        @endif

        {{-- BODEGUERO --}}
        @if($role === 'bodeguero')
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card text-bg-light h-100 border-info">
                    <div class="card-body text-center">
                        <i class="bi bi-box-seam display-4 text-info"></i>
                        <h5 class="card-title mt-3">Bodega</h5>
                        <a href="/bodegas" class="btn btn-sm btn-info mt-2 text-white">Ir</a>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
