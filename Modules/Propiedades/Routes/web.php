<?php

use Modules\Propiedades\Http\Controllers\PropiedadesController;
use Illuminate\Support\Facades\Route;
app()->make('router')->aliasMiddleware('permisson', \Spatie\Permission\Middlewares\PermissionMiddleware::class);

Route::middleware('auth')->prefix('admin/propiedades')->group(function() {
    Route::controller(PropiedadesController::class)->group(function () {
        Route::get('/', 'index')->middleware(['permisson:read propiedades'])->name('propiedades.index');
        Route::post('/', 'store')->middleware(['permisson:create propiedades'])->name('propiedades.store');
        Route::post('/show', 'show')->middleware(['permisson:read propiedades'])->name('propiedades.show');
        Route::put('/', 'update')->middleware(['permisson:update propiedades'])->name('propiedades.update');
        Route::delete('/', 'destroy')->middleware(['permisson:delete propiedades'])->name('propiedades.destroy');
    });
});
