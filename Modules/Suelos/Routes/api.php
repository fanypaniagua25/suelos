<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/suelos', function (Request $request) {
    return $request->user();
});