<?php

use Modules\Cultivos\Http\Controllers\CultivosController;
use Illuminate\Support\Facades\Route;
app()->make('router')->aliasMiddleware('permisson', \Spatie\Permission\Middlewares\PermissionMiddleware::class);

Route::middleware('auth')->prefix('admin/cultivos')->group(function() {
    Route::controller(CultivosController::class)->group(function () {
        Route::get('/', 'index')->middleware(['permisson:read cultivos'])->name('cultivos.index');
        Route::post('/', 'store')->middleware(['permisson:create cultivos'])->name('cultivos.store');
        Route::post('/show', 'show')->middleware(['permisson:read cultivos'])->name('cultivos.show');
        Route::put('/', 'update')->middleware(['permisson:update cultivos'])->name('cultivos.update');
        Route::delete('/', 'destroy')->middleware(['permisson:delete cultivos'])->name('cultivos.destroy');
    });
});
