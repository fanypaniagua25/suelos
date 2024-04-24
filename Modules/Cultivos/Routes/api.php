<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/cultivos', function (Request $request) {
    return $request->user();
});