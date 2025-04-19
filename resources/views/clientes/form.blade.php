<div class="mb-3">
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $cliente->nombre ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="apellido">Apellido</label>
    <input type="text" name="apellido" class="form-control" value="{{ old('apellido', $cliente->apellido ?? '') }}">
</div>

<div class="mb-3">
    <label for="email">Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $cliente->email ?? '') }}">
</div>

<div class="mb-3">
    <label for="telefono">Teléfono</label>
    <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $cliente->telefono ?? '') }}">
</div>

<div class="mb-3">
    <label for="direccion">Dirección</label>
    <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $cliente->direccion ?? '') }}">
</div>

<div class="mb-3">
    <label for="dni">DNI</label>
    <input type="text" name="dni" class="form-control" value="{{ old('dni', $cliente->dni ?? '') }}">
</div>

<div class="mb-3">
    <label for="tipo">Tipo</label>
    <select name="tipo" class="form-select">
        <option value="consumidor_final" {{ old('tipo', $cliente->tipo ?? '') == 'consumidor_final' ? 'selected' : '' }}>Consumidor Final</option>
        <option value="empresa" {{ old('tipo', $cliente->tipo ?? '') == 'empresa' ? 'selected' : '' }}>Empresa</option>
    </select>
</div>
