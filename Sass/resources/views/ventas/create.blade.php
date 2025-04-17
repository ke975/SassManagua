@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">🛒 Nueva Venta</h1>

    <form action="{{ route('ventas.store') }}" method="POST">
        @csrf
        <div class="row">
            <!-- Columna Izquierda -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="cliente_id" class="form-label">Cliente</label>
                    <div class="d-flex gap-2">
                        <select class="form-select" id="cliente_id" name="cliente_id" required>
                            <option value="">Seleccionar Cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                            @endforeach
                        </select>
                        <a href="{{ route('clientes.create') }}" class="btn btn-outline-primary">+</a>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="caja_id" class="form-label">Caja</label>
                    <select class="form-select" id="caja_id" name="caja_id" required>
                        <option value="">Seleccionar Caja</option>
                        @foreach($cajas as $caja)
                            <option value="{{ $caja->id }}">{{ $caja->nombreCaja }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="codigo_barra" class="form-label">📷 Escanear Código de Barras</label>
                    <input type="text" class="form-control" id="codigo_barra" placeholder="Escanea o escribe el código">
                </div>
            </div>

            <!-- Columna Derecha -->
            <div class="col-md-6">
                <h5 class="mb-3">🧾 Detalles de Productos</h5>
                <table class="table table-sm table-bordered" id="tabla-productos">
                    <thead class="table-light">
                        <tr>
                            <th>Producto</th>
                            <th>Cant.</th>
                            <th>Precio</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Aquí se agregan productos dinámicamente --}}
                    </tbody>
                </table>

                <input type="hidden" name="total" id="total">
                <div class="text-end">
                    <h4>Total: <span class="badge bg-success fs-5">$<span id="total-texto">0.00</span></span></h4>
                </div>
            </div>
        </div>

        <div class="text-end mt-4">
            <button type="submit" class="btn btn-success btn-lg">💾 Registrar Venta</button>
        </div>
    </form>
</div>

<script>
    const productos = @json($productos);
    let detalles = [];
    let typingTimer;
    const typingDelay = 300; // milisegundos para considerar que se terminó de escribir
    const inputCodigo = document.getElementById('codigo_barra');

    inputCodigo.addEventListener('input', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => {
            let codigo = this.value.trim();
            if (codigo !== '') {
                let producto = productos.find(p => p.codigo_barra === codigo);
                if (producto) {
                    agregarProducto(producto);
                    this.value = '';
                } else {
                    alert('Producto no encontrado');
                }
            }
        }, typingDelay);
    });

    function agregarProducto(producto) {
        let existente = detalles.find(d => d.id === producto.id);
        if (existente) {
            existente.cantidad++;
        } else {
            detalles.push({ ...producto, cantidad: 1 });
        }
        renderizarTabla();
    }

    function eliminarProducto(id) {
        detalles = detalles.filter(d => d.id !== id);
        renderizarTabla();
    }

    function renderizarTabla() {
        let tbody = document.querySelector('#tabla-productos tbody');
        tbody.innerHTML = '';
        let total = 0;

        detalles.forEach((p, index) => {
            let subtotal = p.cantidad * p.precio;
            total += subtotal;

            tbody.innerHTML += `
                <tr>
                    <td>
                        ${p.nombre_producto}
                        <input type="hidden" name="productos[${index}][id]" value="${p.id}">
                    </td>
                    <td>
                        <input type="number" name="productos[${index}][cantidad]" value="${p.cantidad}" min="1" onchange="cambiarCantidad(${p.id}, this.value)">
                    </td>
                    <td>${p.precio}</td>
                    <td>${subtotal.toFixed(2)}</td>
                    <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarProducto(${p.id})">X</button></td>
                </tr>
            `;
        });

        document.getElementById('total-texto').innerText = total.toFixed(2);
        document.getElementById('total').value = total.toFixed(2);
    }

    function cambiarCantidad(id, nuevaCantidad) {
        let p = detalles.find(d => d.id === id);
        if (p) {
            p.cantidad = parseInt(nuevaCantidad);
            renderizarTabla();
        }
    }
</script>

@endsection
