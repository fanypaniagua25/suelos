<?php

use Modules\Coberturasuelos\Http\Controllers\CoberturasuelosController;
use Illuminate\Support\Facades\Route;
app()->make('router')->aliasMiddleware('permisson', \Spatie\Permission\Middlewares\PermissionMiddleware::class);

Route::middleware('auth')->prefix('admin/coberturasuelos')->group(function() {
    Route::controller(CoberturasuelosController::class)->group(function () {
        Route::get('/', 'index')->middleware(['permisson:read coberturasuelos'])->name('coberturasuelos.index');
        Route::post('/', 'store')->middleware(['permisson:create coberturasuelos'])->name('coberturasuelos.store');
        Route::post('/show', 'show')->middleware(['permisson:read coberturasuelos'])->name('coberturasuelos.show');
        Route::put('/', 'update')->middleware(['permisson:update coberturasuelos'])->name('coberturasuelos.update');
        Route::delete('/', 'destroy')->middleware(['permisson:delete coberturasuelos'])->name('coberturasuelos.destroy');
    });
});
