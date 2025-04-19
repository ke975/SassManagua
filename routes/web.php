<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\BodegaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VentaController;

// Rutas públicas (login)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::resource('users', UserController::class);
// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {

  
    // Cerrar sesión
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Panel general para usuarios autenticados
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Panel solo para administradores
    Route::get('/admin', function () {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }
        return view('dashboard');
    })->name('admin.panel');

    // Panel solo para vendedores
    Route::get('/vendedor', function () {
        if (auth()->user()->role !== 'vendedor') {
            abort(403, 'Acceso no autorizado');
        }
        return view('dashboard');
    })->name('vendedor.panel');

    Route::get('/bodeguero', function () {
        if (auth()->user()->role !== 'bodeguero') {
            abort(403, 'Acceso no autorizado');
        }
        return view('dashboard');
    })->name('bodeguero.panel');  

    // CRUD de usuarios solo accesible a usuarios autenticados


// Mostrar lista de proveedores
Route::get('proveedores', [ProveedorController::class, 'index'])->name('proveedores.index');

// Mostrar formulario para crear un nuevo proveedor
Route::get('proveedores/create', [ProveedorController::class, 'create'])->name('proveedores.create');

// Guardar nuevo proveedor
Route::post('proveedores', [ProveedorController::class, 'store'])->name('proveedores.store');

// Mostrar formulario para editar un proveedor
Route::get('proveedores/{id}/edit', [ProveedorController::class, 'edit'])->name('proveedores.edit');

// Actualizar un proveedor
Route::put('proveedores/{id}', [ProveedorController::class, 'update'])->name('proveedores.update');

// Eliminar un proveedor
Route::delete('proveedores/{id}', [ProveedorController::class, 'destroy'])->name('proveedores.destroy');
Route::resource('inventario', InventarioController::class);
Route::resource('cajas', CajaController::class);
Route::resource('bodegas', BodegaController::class);

Route::resource('clientes', ClienteController::class);
Route::resource('ventas', VentaController::class);
Route::get('/ventas/{venta}/factura', [App\Http\Controllers\VentaController::class, 'factura'])->name('ventas.factura');

});

