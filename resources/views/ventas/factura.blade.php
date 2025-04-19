@extends('layouts.app')

@section('content')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #voucher, #voucher * {
            visibility: visible;
        }
        #voucher {
            position: absolute;
            left: 0;
            top: 0;
            width: 80mm;
            font-size: 12px;
        }
    }

    #voucher {
        max-width: 80mm;
        margin: auto;
        font-family: monospace;
        font-size: 12px;
    }

    .voucher-header,
    .voucher-footer {
        text-align: center;
        margin-bottom: 10px;
    }

    .voucher-table {
        width: 100%;
        border-collapse: collapse;
    }

    .voucher-table th,
    .voucher-table td {
        padding: 2px 0;
        border-bottom: 1px dashed #ccc;
        text-align: left;
    }

    .text-right {
        text-align: right;
    }

    .total {
        font-weight: bold;
        font-size: 14px;
    }
</style>

<div id="voucher">
    <div class="voucher-header">
        <h4>SÚPER MERCADO XYZ</h4>
        <p>🧾 Factura #{{ $venta->id }}</p>
        <p>Fecha: {{ $venta->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <div>
        <p><strong>Cliente:</strong> {{ $venta->cliente->nombre }}</p>
        <p><strong>Caja:</strong> {{ $venta->caja->nombreCaja }}</p>
    </div>

    <table class="voucher-table">
        <thead>
            <tr>
                <th>Producto</th>
                <th class="text-right">Cant</th>
                <th class="text-right">P.U.</th>
                <th class="text-right">Sub</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($venta->detalles as $detalle)
                <tr>
                    <td>{{ $detalle->producto->nombre_producto }}</td>
                    <td class="text-right">{{ $detalle->cantidad }}</td>
                    <td class="text-right">${{ number_format($detalle->producto->precio, 2) }}</td>
                    <td class="text-right">${{ number_format($detalle->producto->precio * $detalle->cantidad, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="text-right total">TOTAL: ${{ number_format($venta->total, 2) }}</p>

    <div class="voucher-footer">
        <p>Gracias por su compra 🙌</p>
        <p>www.supermercadoxyz.com</p>
    </div>

    <div class="text-center">
        <button class="btn btn-primary btn-sm d-print-none" onclick="window.print()">🖨 Imprimir</button>
    </div>
</div>
<script>
    window.onload = () => window.print();
</script>

@endsection
