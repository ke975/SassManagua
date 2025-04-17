@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">✏️ Editar Venta</h1>

    <form action="{{ route('ventas.update', $venta->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <!-- Columna Izquierda -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Cliente</label>
                    <input type="text" class="form-control" value="{{ $venta->cliente->nombre }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="caja_id" class="form-label">Caja</label>
                    <select class="form-select" id="caja_id" name="caja_id" required>
                        @foreach($cajas as $caja)
                            <option value="{{ $caja->id }}" {{ $venta->caja->id == $caja->id ? 'selected' : '' }}>
                                {{ $caja->nombreCaja }}
                            </option>
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
                        @foreach($venta->detalles as $index => $detalle)
                        <tr>
                            <td>
                                {{ $detalle->producto->nombre_producto }}
                                <input type="hidden" name="productos[{{ $index }}][id]" value="{{ $detalle->producto->id }}">
                            </td>
                            <td>
                                <input type="number" name="productos[{{ $index }}][cantidad]" value="{{ $detalle->cantidad }}" min="1" onchange="cambiarCantidad({{ $detalle->producto->id }}, this.value)">
                            </td>
                            <td>
                                <input type="number" name="productos[{{ $index }}][precio_unitario]" value="{{ $detalle->precio_unitario }}" step="0.01" required>
                            </td>
                            <td>{{ number_format($detalle->cantidad * $detalle->precio_unitario, 2) }}</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarProducto({{ $detalle->producto->id }})">X</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <input type="hidden" name="total" id="total">
                <div class="text-end">
                    <h4>Total: <span class="badge bg-success fs-5">$<span id="total-texto">0.00</span></span></h4>
                </div>
            </div>
        </div>

        <div class="text-end mt-4">
            <button type="submit" class="btn btn-success btn-lg">💾 Guardar Cambios</button>
        </div>
    </form>
</div>

<script>
    const productosDisponibles = @json($productos);

    let detalles = {!! json_encode($venta->detalles->map(function($d) {
        return [
            'id' => $d->producto->id,
            'nombre_producto' => $d->producto->nombre_producto,
            'precio' => $d->precio_unitario,
            'cantidad' => $d->cantidad,
        ];
    })) !!};

    let typingTimer;
    const typingDelay = 300;
    const inputCodigo = document.getElementById('codigo_barra');

    inputCodigo.addEventListener('input', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => {
            let codigo = this.value.trim();
            if (codigo !== '') {
                let producto = productosDisponibles.find(p => p.codigo_barra === codigo);
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
            detalles.push({
                id: producto.id,
                nombre_producto: producto.nombre_producto,
                precio: producto.precio,
                cantidad: 1
            });
        }
        renderizarTabla();
    }

    function eliminarProducto(id) {
        detalles = detalles.filter(d => d.id !== id);
        renderizarTabla();
    }

    function cambiarCantidad(id, nuevaCantidad) {
        let p = detalles.find(d => d.id === id);
        if (p) {
            p.cantidad = parseInt(nuevaCantidad);
            renderizarTabla();
        }
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
                        <input type='hidden' name='productos[${index}][id]' value='${p.id}'>
                    </td>
                    <td>
                        <input type='number' name='productos[${index}][cantidad]' value='${p.cantidad}' min='1' onchange='cambiarCantidad(${p.id}, this.value)'>
                    </td>
                    <td>
                        <input type='number' name='productos[${index}][precio_unitario]' value='${p.precio}' step='0.01' required>
                    </td>
                    <td>${subtotal.toFixed(2)}</td>
                    <td><button type='button' class='btn btn-danger btn-sm' onclick='eliminarProducto(${p.id})'>X</button></td>
                </tr>
            `;
        });

        document.getElementById('total-texto').innerText = total.toFixed(2);
        document.getElementById('total').value = total.toFixed(2);
    }

    renderizarTabla();
</script>
@endsection