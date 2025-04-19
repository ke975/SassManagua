<div class="mb-3">
    <label>Bodega</label>
    <select name="bodega_id" class="form-control">
        @foreach($bodegas as $bodega)
            <option value="{{ $bodega->id }}"
                {{ (isset($inventario) && $inventario->bodega_id == $bodega->id) ? 'selected' : '' }}>
                {{ $bodega->nombre }}
            </option>
        @endforeach
    </select>
    @error('bodega_id')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label>Código de barra</label>
    <input type="text" name="codigo_barra" class="form-control"
           value="{{ old('codigo_barra', $inventario->codigo_barra ?? '') }}" required>
    @error('codigo_barra')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label>Nombre del producto</label>
    <input type="text" name="nombre_producto" class="form-control"
           value="{{ old('nombre_producto', $inventario->nombre_producto ?? '') }}" required>
    @error('nombre_producto')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label>Precio</label>
    <input type="number" step="0.01" name="precio" class="form-control"
           value="{{ old('precio', $inventario->precio ?? '') }}" required>
    @error('precio')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label>Stock inicial</label>
    <input type="number" name="stock" class="form-control"
           value="{{ old('stock', $inventario->stock ?? 0) }}" min="0" required>
    @error('stock')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<button class="btn btn-primary">Guardar</button>
