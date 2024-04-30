<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductApiController;
use App\Http\Controllers\UserApiController;

Route::prefix('v1')->group(function () {

    Route::get('/welcome', function (Request $request) {
        return response()->json([
            'title' => 'Stock Management App',
        ]);
    });

    Route::resource('products', ProductApiController::class)
        ->middleware('auth:sanctum')
        ->name('index', 'products.index')
        ->name('show', 'products.show')
        ->name('store', 'products.store')
        ->name('update', 'products.update')
        ->name('destroy', 'products.delete');
    // Route::get('/products', [ProductApiController::class, 'index'])->name('products.index');
    // Route::get('/products/{id}', [ProductApiController::class, 'show'])->name('products.show');
    // Route::post('/products', [ProductApiController::class, 'store'])->name('products.store');
    // Route::put('/products/{id}', [ProductApiController::class, 'update'])->name('products.update');
    // Route::delete('/products/{id}', [ProductApiController::class, 'destroy'])->name('products.destroy');

    Route::resource('users', UserApiController::class)
        ->middleware('auth:sanctum')
        ->name('index', 'users.index')
        ->name('show', 'users.show')
        ->name('store', 'users.store')
        ->name('update', 'users.update')
        ->name('destroy', 'users.delete');

    Route::post('/login', [UserApiController::class, 'login'])->name('users.login');
    Route::post('/register', [UserApiController::class, 'register'])->name('users.register');
});

