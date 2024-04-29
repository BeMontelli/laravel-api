<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {

    Route::get('/welcome', function (Request $request) {
        return 'Stock Managament App';
    });

});

Route::prefix('v2')->group(function () {

    Route::get('/welcome', function (Request $request) {
        return response()->json([
            'title' => 'Stock Managament App',
        ]);
    });

});

