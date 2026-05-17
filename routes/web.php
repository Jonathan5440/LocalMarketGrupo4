<?php

use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\ComercioController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

// ── Raíz ──────────────────────────────────────────────────────────────────────
Route::get('/', function () {
    if (auth()->check()) {
        return match (auth()->user()->role) {
            \App\Enums\Role::Admin       => redirect()->route('admin.dashboard'),
            \App\Enums\Role::Comerciante => redirect()->route('comercio.dashboard'),
            \App\Enums\Role::Comprador   => redirect()->route('tienda.index'),
            \App\Enums\Role::Repartidor  => redirect()->route('repartidor.dashboard'),
        };
    }
    return redirect()->route('login');
});

// ── Admin ──────────────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categorias', CategoriaController::class);
    Route::resource('comercios', ComercioController::class);
    Route::post('comercios/{comercio}/toggle', [ComercioController::class, 'toggleActivo'])->name('comercios.toggle');
});

// ── Comerciante ────────────────────────────────────────────────────────────────
Route::prefix('comercio')->name('comercio.')->middleware(['auth', 'role:comerciante'])->group(function () {
    Route::get('/dashboard', function () {
        return view('comercio.dashboard');
    })->name('dashboard');
});

// ── Comprador / Tienda ─────────────────────────────────────────────────────────
Route::prefix('tienda')->name('tienda.')->middleware(['auth', 'role:comprador'])->group(function () {
    Route::get('/', function () {
        return view('tienda.index');
    })->name('index');
});

// ── Repartidor ─────────────────────────────────────────────────────────────────
Route::prefix('repartidor')->name('repartidor.')->middleware(['auth', 'role:repartidor'])->group(function () {
    Route::get('/dashboard', function () {
        return view('repartidor.dashboard');
    })->name('dashboard');
});

// ── Auth (Breeze) ──────────────────────────────────────────────────────────────
require __DIR__.'/auth.php';
