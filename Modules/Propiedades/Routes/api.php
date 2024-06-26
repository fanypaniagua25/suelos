<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/propiedades', function (Request $request) {
    return $request->user();
});