<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Ruta principal abierta: Menú completo, presentación e-commerce y catálogo estilo Buscamed
// Ruta principal: Si es administrador se redirige a su panel; si es cliente o visitante ve el catálogo
Route::get('/', function (\Illuminate\Http\Request $request) {
    if (Auth::check() && Auth::user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return app(ClientController::class)->inicio($request);
})->name('home');

// Redirección del dashboard según el rol
Route::get('/dashboard', function () {
    if (Auth::user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('client.inicio');
})->middleware(['auth'])->name('dashboard');

Route::post('/cambiar-rol/{role}', function (string $role) {
    if (!in_array($role, ['cliente', 'admin'])) {
        abort(400);
    }
    $user = Auth::user();
    $user->role = $role;
    $user->save();

    if ($role === 'admin') {
        return redirect()->route('admin.dashboard')->with('success', 'Has cambiado al modo Administrador.');
    }
    return redirect()->route('client.inicio')->with('success', 'Has cambiado al modo Cliente.');
})->middleware('auth')->name('cambiar.rol');

// RUTAS PÚBLICAS DEL CLIENTE / CATÁLOGO
Route::prefix('cliente')->name('client.')->group(function () {
    Route::get('/inicio', [ClientController::class, 'inicio'])->name('inicio');
    Route::get('/buscar', [ClientController::class, 'buscar'])->name('buscar');
    Route::get('/platillo/{id}', [ClientController::class, 'platillo'])->name('platillo');
    Route::post('/platillo/{id}/agregar', [ClientController::class, 'agregarAlCarrito'])->name('agregar');
});

// RUTAS DEL CLIENTE CON AUTENTICACIÓN
Route::middleware('auth')->prefix('cliente')->name('client.')->group(function () {
    Route::post('/platillo/{id}/review', [ClientController::class, 'guardarReview'])->name('review');

    Route::get('/carrito', [ClientController::class, 'carrito'])->name('carrito');
    Route::post('/carrito/{id}/cantidad', [ClientController::class, 'actualizarCantidad'])->name('carrito.cantidad');
    Route::post('/carrito/{id}/toggle', [ClientController::class, 'toggleSeleccion'])->name('carrito.toggle');
    Route::post('/carrito/eliminar', [ClientController::class, 'eliminarDelCarrito'])->name('carrito.eliminar');
    Route::post('/carrito/pagar', [ClientController::class, 'pagar'])->name('carrito.pagar');
    Route::get('/ticket/{order_id}', [ClientController::class, 'ticket'])->name('ticket');

    Route::get('/perfil', [ClientController::class, 'perfil'])->name('perfil');
    Route::post('/perfil/editar', [ClientController::class, 'editarPerfil'])->name('perfil.editar');

    Route::get('/configuracion', [ClientController::class, 'configuracion'])->name('configuracion');
});

// RUTAS DEL ADMINISTRADOR
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/pedidos', [AdminController::class, 'pedidos'])->name('pedidos');
    Route::get('/pedidos/{id}', [AdminController::class, 'verPedido'])->name('pedidos.ver');
    Route::post('/pedidos/{id}/estado', [AdminController::class, 'actualizarEstadoPedido'])->name('pedidos.estado');

    Route::get('/productos', [AdminController::class, 'productos'])->name('productos');
    Route::get('/productos/nuevo', [AdminController::class, 'crearProducto'])->name('productos.crear');
    Route::post('/productos/nuevo', [AdminController::class, 'almacenarProducto'])->name('productos.almacenar');

    Route::get('/productos/{id}/editar', [AdminController::class, 'editarProducto'])->name('productos.editar');
    Route::post('/productos/{id}/guardar', [AdminController::class, 'guardarProducto'])->name('productos.guardar');
    Route::delete('/productos/{id}', [AdminController::class, 'eliminarProducto'])->name('productos.eliminar');
    Route::delete('/reviews/{id}', [AdminController::class, 'eliminarReview'])->name('reviews.eliminar');

    Route::get('/configuracion', [AdminController::class, 'configuracion'])->name('configuracion');
    Route::post('/configuracion', [AdminController::class, 'actualizarConfiguracion'])->name('configuracion.actualizar');
});

// Rutas Legales Públicas
Route::view('/terminos-y-condiciones', 'legal.terminos')->name('legal.terminos');
Route::view('/aviso-de-privacidad', 'legal.privacidad')->name('legal.privacidad');

// Rutas de Perfil estándar
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Verificación de sesión en tiempo real (sondeo sin recargar)
Route::get('/check-session', function () {
    return response()->json([
        'authenticated' => auth()->check(),
    ]);
})->name('check.session');
