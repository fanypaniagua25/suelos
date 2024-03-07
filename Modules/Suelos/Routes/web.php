<?php

use Modules\Suelos\Http\Controllers\SuelosController;
use Illuminate\Support\Facades\Route;
app()->make('router')->aliasMiddleware('permisson', \Spatie\Permission\Middlewares\PermissionMiddleware::class);

Route::middleware('auth')->prefix('admin/suelos')->group(function() {
    Route::controller(SuelosController::class)->group(function () {
        Route::get('/', 'index')->middleware(['permisson:read suelos'])->name('suelos.index');
        Route::post('/', 'store')->middleware(['permisson:create suelos'])->name('suelos.store');
        Route::post('/show', 'show')->middleware(['permisson:read suelos'])->name('suelos.show');
        Route::put('/', 'update')->middleware(['permisson:update suelos'])->name('suelos.update');
        Route::delete('/', 'destroy')->middleware(['permisson:delete suelos'])->name('suelos.destroy');
        Route::get('/obtener-datos', [SuelosController::class, 'obtenerDatos']);
        Route::post('/guardar-cambios', [SuelosController::class, 'guardarCambios']);
    });
});

