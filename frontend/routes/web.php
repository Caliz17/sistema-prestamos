<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Front\ClienteController as ClienteController;
use App\Http\Controllers\Front\PrestamoController as PrestamoController;
use App\Http\Controllers\Front\SolicitudController as SolicitudController;
use App\Http\Controllers\Front\PagoController as PagoController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('reset-password/{token}', function (Request $request, $token) {
    $email = $request->query('email');

    if (!$email) {
        abort(400, 'Falta parámetro email');
    }

    return view('auth.reset-password', [
        'token' => $token,
        'email' => $email
    ]);
})->name('password.reset-custom');

Route::get('/dashboard', [App\Http\Controllers\Front\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Clientes
    Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('/clientes/create', [ClienteController::class, 'create'])->name('clientes.create');
    Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
    Route::get('/clientes/{id}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');
    Route::put('/clientes/{id}', [ClienteController::class, 'update'])->name('clientes.update');
    Route::delete('/clientes/{id}', [ClienteController::class, 'destroy'])->name('clientes.destroy');

    // Préstamos
    Route::get('/prestamos', [PrestamoController::class, 'index'])->name('prestamos.index');
    Route::get('/prestamos/crear', [PrestamoController::class, 'create'])->name('prestamos.create');
    Route::post('/prestamos', [PrestamoController::class, 'store'])->name('prestamos.store');
    Route::get('/prestamos/{id}', [PrestamoController::class, 'show'])->name('prestamos.show');
    Route::put('/prestamos/{id}', [PrestamoController::class, 'update'])->name('prestamos.update');
    Route::delete('/prestamos/{id}', [PrestamoController::class, 'destroy'])->name('prestamos.destroy');

    // Prestamos por cliente
    Route::get('/prestamos/cliente/{cliente_id}', [PrestamoController::class, 'prestamosPorCliente'])
        ->name('prestamos.cliente');
    // Crear préstamo desde una solicitud aprobada
    Route::get(
        '/prestamos/crear-desde-solicitud/{id}',
        [PrestamoController::class, 'createFromSolicitud']
    )->name('prestamos.createDesdeSolicitud');

    /* === SOLICITUDES === */
    Route::get('/solicitudes', [SolicitudController::class, 'index'])->name('solicitudes.index');
    Route::get('/solicitudes/crear', [SolicitudController::class, 'create'])->name('solicitudes.create');
    Route::post('/solicitudes', [SolicitudController::class, 'store'])->name('solicitudes.store');
    Route::get('/solicitudes/{id}', [SolicitudController::class, 'show'])->name('solicitudes.show');
    Route::get('/solicitudes/{id}/edit', [SolicitudController::class, 'edit'])->name('solicitudes.edit'); // 🔥 FALTABA
    Route::put('/solicitudes/{id}', [SolicitudController::class, 'update'])->name('solicitudes.update');
    Route::delete('/solicitudes/{id}', [SolicitudController::class, 'destroy'])->name('solicitudes.destroy');

    // Acciones
    Route::put('/solicitudes/{id}/aprobar', [SolicitudController::class, 'aprobar'])
        ->name('solicitudes.aprobar');
    Route::put('/solicitudes/{id}/rechazar', [SolicitudController::class, 'rechazar'])
        ->name('solicitudes.rechazar');

    // Solicitudes por cliente
    Route::get('/solicitudes/cliente/{cliente_id}', [SolicitudController::class, 'solicitudesPorCliente'])
        ->name('solicitudes.cliente');



    /* === PAGOS === */
    /* === PAGOS === */
    Route::get('/pagos', [PagoController::class, 'index'])->name('pagos.index');
    Route::post('/pagos', [PagoController::class, 'store'])->name('pagos.store');
    Route::get('/pagos/{id}', [PagoController::class, 'show'])->name('pagos.show');


});
require __DIR__.'/auth.php';
