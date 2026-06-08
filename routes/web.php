<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/users', function () {
//     return view('user');
// });

// Route::get('/customers', function () {
//     return view('customer');
// });

Route::get('/users', [UserController::class, 'index'])
    ->name('users.index');
Route::get('/customers', [CustomerController::class, 'index'])
    ->name('customers.index');
Route::get('/users/{id}', [UserController::class, 'show'])
    ->name('users.show')
    ->where('id', '[0-9]+');
Route::get('/users/{username}/{email}', [UserController::class, 'getUsernameEmail'])
    ->name('users.getUsernameEmail');

// Categories routes:
Route::get('/categories', [CategoryController::class, 'index'])
    ->name('categories.index');
Route::get('/categories/create', [CategoryController::class, 'create'])
    ->name('categories.create');
Route::post('/categories/store', [CategoryController::class, 'store'])
    ->name('categories.store');
Route::get('/categories/{id}', [CategoryController::class, 'edit'])
    ->name('categories.edit');
Route::put('/categories/{id}', [CategoryController::class, 'update'])
    ->name('categories.update');
Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])
    ->name('categories.destroy');

// Products routes:
Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])
    ->name('products.create');
Route::post('/products/store', [ProductController::class, 'store'])
    ->name('products.store');
Route::get('/products/{id}', [ProductController::class, 'edit'])
    ->name('products.edit');
Route::put('/products/{id}', [ProductController::class, 'update'])
    ->name('products.update');
