<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController as ApiProductController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// public 
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/categories', [CategoryController::class, 'index'])
    ->name('api.categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])
    ->name('api.categories.show');

Route::get('/products', [ApiProductController::class, 'index'])
    ->name('api.products.index');
Route::get('/products/{product}', [ApiProductController::class, 'show'])
    ->name('api.products.show');

Route::middleware('auth:sanctum')->group(function () {
    //  protect route
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // route apiResource categories
    Route::post('/categories', [CategoryController::class, 'store'])
        ->name('api.categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])
        ->name('api.categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])
        ->name('api.categories.destroy');

    // Product API Routes
    Route::post('/products', [ApiProductController::class, 'store'])
        ->name('api.products.store');
    Route::put('/products/{product}', [ApiProductController::class, 'update'])
        ->name('api.products.update');
    Route::delete('/products/{product}', [ApiProductController::class, 'destroy'])
        ->name('api.products.destroy');
});
