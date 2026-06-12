<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products',[ProductController::class,'index']);

// route apiResource categories
Route::apiResource('categories',CategoryController::class)
->names([
    'index'=>'api.categories.index',
    'store'=>'api.categories.store',
    'show'=>'api.categories.show',
    'update'=>'api.categories.update',
    'destroy'=>'api.categories.destroy',
]);