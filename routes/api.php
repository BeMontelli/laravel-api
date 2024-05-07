<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ProductApiController;
use App\Http\Controllers\UserApiController;
use App\Http\Controllers\CategoryApiController;

Route::prefix('v1')->group(function () {

    Route::get('/welcome', [ApiController::class,'index'])->name('api.welcome');

    Route::resource('products', ProductApiController::class)
        ->middleware('auth:sanctum')
        ->name('index', 'products.index')
        ->name('show', 'products.show')
        ->name('store', 'products.store')
        ->name('update', 'products.update')
        ->name('destroy', 'products.delete');

    Route::resource('users', UserApiController::class)
        ->middleware('auth:sanctum')
        ->name('index', 'users.index')
        ->name('show', 'users.show')
        ->name('store', 'users.store')
        ->name('update', 'users.update')
        ->name('destroy', 'users.delete');

    Route::resource('categories', CategoryApiController::class)
        ->middleware('auth:sanctum')
        ->name('index', 'categories.index')
        ->name('show', 'categories.show')
        ->name('store', 'categories.store')
        ->name('update', 'categories.update')
        ->name('destroy', 'categories.delete');

    Route::post('/login', [UserApiController::class, 'login'])->name('users.login');
    Route::post('/register', [UserApiController::class, 'register'])->name('users.register');
});

