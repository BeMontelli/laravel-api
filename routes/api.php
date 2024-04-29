<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {

    Route::get('/welcome', function (Request $request) {
        return response()->json([
            'title' => 'Stock Management App',
        ]);
    });

    Route::resource('products', ProductApiController::class);
    // Route::get('/products', [ProductApiController::class, 'index'])->name('products.index');
    // Route::get('/products/{id}', [ProductApiController::class, 'show'])->name('products.show');
    // Route::post('/products', [ProductApiController::class, 'store'])->name('products.store');
    // Route::put('/products/{id}', [ProductApiController::class, 'update'])->name('products.update');
    // Route::delete('/products/{id}', [ProductApiController::class, 'destroy'])->name('products.destroy');

});

