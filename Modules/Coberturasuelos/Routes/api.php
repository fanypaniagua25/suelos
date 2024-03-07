<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/coberturasuelos', function (Request $request) {
    return $request->user();
});